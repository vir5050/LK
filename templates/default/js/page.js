function isVisible(el) {
    if (!el) return false;
    return (el.classList.contains('active') && !el.classList.contains('no-display'));
}

function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}

function isObject(obj) {
    return Object.prototype.toString.call(obj) === '[object Object]';
}

function isFunction(obj) {
    return Object.prototype.toString.call(obj) === '[object Function]';
}

function isChecked(el) {
    if (el.getAttribute('type').toLowerCase() == 'checkbox') {
        return (el.checked === true) ? 1 : 0;
    }
}

function toggle(el) {
    if (isVisible(el)) {
        el.classList.remove('active');
    } else {
        el.classList.add('active');
    }
}

function hide(el) {
    el.classList.add('no-display');
}

function show(el) {
    el.classList.remove('no-display');
}

function setStyle(el, name, value) {
    if (!el) return;
    if (typeof name == 'object') {
        return each(name, function(k, v) {
            setStyle(el, k, v);
        });
    }

    try {
        var isN = typeof(value) == 'number';
        if (isN && (/height|width/i).test(name)) value = Math.abs(value);
        el.style[name] = isN && !(/z-?index|opacity|zoom/i).test(name) ? value + 'px' : value;
    } catch(e) { console.log('setStyle error [%s], name: "%s", value: "%s".', e, name, value); }
}

function ce(tag, attr, style) {
    var el = document.createElement(tag);
    if (isObject(attr)) {
        for (var key in attr) {
            if (attr[key] == null) continue;
            el.setAttribute(key, attr[key]);
        }
    }

    if (style) setStyle(el, style);

    return el;
}

function ge(el) {
    return (typeof el == 'string') ? document.getElementById(el) : el;
}

function qs(selector, target) {
    return (target || document).querySelector(selector);
}

function qsall(selector, target) {
    return (target || document).querySelectorAll(selector);
}

function each(object, callback) {
    var name, i = 0, length = object.length;

    if (length === undefined) {
        for (name in object)
            if (callback.call(object[name], name, object[name]) === false)
                break;
    } else {
        for (var value = object[0];
             i < length && callback.call(value, i, value) !== false;
             value = object[++i]) {}
    }

    return object;
}

function dispose(el) {
    el.parentElement.removeChild(el);
}

function getParent(node, id, tag) {
    var parent = node.parentNode;
    if (id && parent.id != id) {
        parent = getParent(parent, id);
    } else if (tag && parent.tagName.toLowerCase() != tag) {
        parent = getParent(parent, id, tag);
    }

    return parent;
}

function declNum(target, titles, n) {
    var cases = [2, 0, 1, 1, 1, 2];
    var result = titles[(n % 100 > 4 && n % 100 < 20) ? 2 : cases[(n % 10 < 5) ? n % 10 : 5]];

    if (target != false) {
        target.textContent = result;
    } else {
        return result;
    }
}

function getProfit(id, el) {
    var parent = el.parentNode, loader = ce('div', {id:'loader', class:'line-dots-black'}, {height:7, margin:'0 auto'}), r = ce('span');

    if (!id) return;

    ajax.send('POST', 'account/ajax', {act:'get_profit', follower:id}, function() {
        el.classList.add('no-display');
        parent.appendChild(loader);
    }, function(t) {
        delete dispose(loader);
        r.innerHTML = t;
        parent.appendChild(r);
    });
}

function showTooltip(el, content, opts) {
    if (el.ot) return;

    el.ot = new Opentip(el, content, opts);
    el.ot.show();

    return true;
}

function calculateProctype() {
    var ptboxes = qsall('input[data-st=\'item-proctype\']'), field = qs('input[name=proctype]'), proctype = 0;

    if(!ptboxes) return;

    each(ptboxes, function(k, v) {
        if (v.checked == true) {
            proctype += Math.pow(2, v.value);
        }
    });

    field.value = proctype;
}

function checkEvent(e) {
    return ((e = (e || window.event)) && (e.type == 'click' || e.type == 'mousedown' || e.type == 'mouseup')) || false;
}

function setSkillId(id) {
    var f = qs('form[name=\'skill-form\']');
    var s = qs('input[name=\'skillId\']', f);

    s.value = id;
    if (confirm('Подтвердите операцию')) {
        f.submit();
    }
}

function cancelEvent(event) {
    event = (event || window.event);
    if (!event) return false;
    while (event.originalEvent) {
        event = event.originalEvent;
    }
    if (event.preventDefault) event.preventDefault();
    if (event.stopPropagation) event.stopPropagation();
    event.cancelBubble = true;
    event.returnValue = false;
    return false;
}

function go(el, evt, done) {
    evt.preventDefault();

    if (checkEvent(evt)) {
        var url = el.getAttribute('href'),
            t = el.textContent || el.innerText,
            lc = ge('left-content-area');

        if (!url) return;

        ajax.send('GET', url, {}, null, function(r) {
            try {
                if (!history.pushState)
                    throw new Error('history.pushState is undefined');

                t = (/^-?[0-9]+$/.test(t)) ? '' : t.trim();
                history.pushState(r, t, url);
                lc.innerHTML = r;

                if (t != '') document.title = (t === t.toUpperCase() ? t.charAt(0).toUpperCase() + t.slice(1).toLowerCase() : t);

                Page.scrollTo(window.pageYOffset, 265);

                if (isFunction(done)) done();
            } catch(e) { console.log(e.message); }
        });
    } else {
        cancelEvent(evt);
    }

    return false;
}

function calculateAmount(v, min, max, el, evt) {
    if (el.value < min) el.value = min;
    if (el.value > max) el.value = max;

    var a = el.value, b = ge('t-a'), ta;

    if (evt.keyCode == 27 || evt.keyCode == 13) return;

    if ((/^-?[0-9]+$/.test(a))) {

        ta = Math.floor(a * v);
        b.innerHTML = ' - ' + ta + ' ' + declNum(false, price_labels, ta);
    } else {
        b.innerHTML = '';
    }
}

var Page = {
    toggleRow: function(el) {
        var  ul = getParent(el, false, 'ul'), t = function(e) {
            var bl = qs('#hidden-content', getParent(e, false, 'li'));
            toggle(e);
            toggle(bl);
        }, bls = qsall('li > div.list-content', ul);

        each(bls, function(k, v) { if (v != el && isVisible(v)) t(v); });
        t(el);
    },
    removePost: function(url, id) {
        var pb = ge('post-id-' + id);

        if (!pb) return;

        ajax.send('POST', url, {id:id}, function() {
            setStyle(pb, {opacity:0.5, pointerEvents:'none'});
        }, function(r) {
            console.log(r);
            if (r == '1') {
                delete dispose(pb);
            } else {
                pb.removeAttribute('style');
            }
        });
    },
    scrollTo: function(current, target) {
        var diff = parseFloat(target) - parseFloat(current),
            arrived = (Math.abs(diff) <= 0.5), filter = 0.2, fps = 60;

        if (arrived) {
            scrollTo(0.0, target);
            return;
        }

        current = (parseFloat(current) * (1.0 - filter)) + (parseFloat(target) * filter);

        scrollTo(0.0, Math.round(current));
        setTimeout('Page.scrollTo(' + current+', ' + target + ')', (500 / fps));
    }
};

var CharmBar = {
    roles: function(el) {
        var table = qs('table', el), loader = ce('div', {id:'loader', class:'spinner small'}, {margin:'5px auto', position:'relative'});

        if(el.loaded) return false;
        el.loaded = true;

        ajax.send('POST', 'account/ajax', {act:'get_roles'}, function() {
            table.parentNode.insertBefore(loader, table.parentNode.firstChild);
        }, function(r) {
            try {
                delete dispose(loader);
                var roles = JSON.parse(r);
                var sr = el.getAttribute('selected-role');
                each(roles, function(k, v) {
                    var tr = ce('tr'),
                        td = ce('td'),
                        a = ce('a', {class:((v.id == sr) ? 'selected' : '')});
                    var span = ce('span', {class:'role-avatar role-cls s25 cls-' + v.cls});

                    a.innerHTML = v.name;
                    a.addEventListener('click', function() {
                        var sr = qs('[selected-role]').getAttribute('selected-role'), loader = ce('div', {id:'loader', class:'spinner small'}, {right:8, top:8});

                        if (sr == v.id) return;

                        ajax.send('POST', 'account/ajax', {act:'select_role', id:v.id}, function() {
                            setStyle(a, {pointerEvents:'none'});
                            setStyle(loader, {position:'absolute'});
                            a.appendChild(loader, a);
                        }, function(r) {
                            if (r == 1) {
                                window.location.reload();
                            }
                        });
                    });

                    //a.insertBefore(span, a.firstChild);
                    td.appendChild(a);
                    tr.appendChild(td);
                    table.appendChild(tr);
                });
            } catch(e) { table.innerHTML = 'Error'; console.log(e); }
        });
    },
    notifications: function(cnt ,el) {
        if (cnt == 0) return el.blur();

        var ul = qs('ul', el), loader = ce('li', {id:'loader', class:'spinner small'}, {margin:'10px auto', position:'relative', display:'list-item'});

        if(el.loaded) return false;
        el.loaded = true;

        ajax.send('POST', 'account/ajax', {act:'get_notices'}, function() {
            ul.appendChild(loader);
        }, function(r) {
            try {
                delete dispose(loader);
                var notices = JSON.parse(r);
                each(notices, function(k, v) {
                    var li = ce('li'),
                        lc = ce('div', {class:'list-content'}),
                        hc = ce('div', {id:'hidden-content', class:'notice-content'}), data;

                    if (v.notice_data != '') {
                        data = JSON.parse(v.notice_data);
                    }

                    lc.innerHTML = '<div class="preview">\
                        <div class="icon">\
                            <i data-icon="&#xe37c;"></i>\
                        </div>\
                        <div class="text">\
                            <i data-icon="&#xe12c;"></i>\
                            <span style="line-height: 20px;"><h4>' + v.title + '</h4>' + v.message + '</span>\
                        </div>\
                    </div>';

                    if (isObject(data)) {
                        if (data.type == 'store') {
                            lc.addEventListener('mousedown', function() {
                                Page.toggleRow(this);

                                var loader = ce('div', {id:'loader', class:'line-dots-black'}, {height:33, margin:'0 auto'});

                                if(li.loaded) return;
                                li.loaded = true;

                                ajax.send('POST', 'store/ajax', {act:'get_item', sid:data.store_id}, function() {
                                    hc.appendChild(loader);
                                }, function(r) {
                                    var store = JSON.parse(r),
                                        ab = ce('div', {class:'actions'}),
                                        aa = ce('button', {class:'button material-design'}),
                                        ar = ce('button', {class:'button material-design'});

                                    hc.innerHTML = '<a href="store/ajax/preview/' + store.store_id + (typeof(data.item_octet) !== 'undefined' ? '/octet/' + data.item_octet : '') + '" onmouseover="showTooltip(this, \'Preview\', {target:this.parentNode, tipJoint:\'right\', ajax:true, offset:[10, 2]});"><img src="uploads/Icons/' + store.item_id + '.png" /></a><span><h4>' + store.name + '</h4>x' + data.item_count + '</span>';
                                    aa.innerHTML = '<i data-icon="&#xe3dd;"></i>';
                                    ar.innerHTML = '<i data-icon="&#xe3df;"></i>';

                                    aa.addEventListener('click', function() {
                                        (ajax.send('POST', 'account/ajax', {
                                            act: 'accept_gift',
                                            id: v.notice_id
                                        }, function () {
                                            setStyle(aa, {pointerEvents: 'none'});
                                        }, function (r) {
                                            if (r != '') {
                                                try {
                                                    r = JSON.parse(r);

                                                    if (ge('notice-status-msg') != undefined) delete dispose(ge('notice-status-msg'));

                                                    var msg = ce('div', {
                                                        id: 'notice-status-msg',
                                                        class: 'alert alert-' + r.status
                                                    }, {marginBottom: 0});

                                                    if (isObject(r.message)) {
                                                        var ul = ce('ul');
                                                        each(r.message, function (k, v) {
                                                            var li = ce('li');
                                                            li.innerHTML = v;
                                                            ul.appendChild(li);
                                                        });
                                                        msg.appendChild(ul);
                                                    } else {
                                                        msg.innerHTML = r.message;
                                                    }

                                                    ab.parentNode.insertBefore(msg, ab.nextSibling);

                                                    if (r.status == 'success') {
                                                        delete dispose(ab);
                                                    } else {
                                                        aa.removeAttribute('style');
                                                    }
                                                } catch (e) {
                                                    console.log(e);
                                                }
                                            }
                                        }));
                                    }, false);

                                    ar.addEventListener('click', function() {
                                        ajax.send('POST', 'account/ajax', {act:'remove_notice', id:v.notice_id}, function() {
                                            setStyle(aa, {pointerEvents:'none'});
                                        }, function(r) {
                                            if (r == '1') {
                                                delete dispose(li);
                                            } else {
                                                ar.removeAttribute('style');
                                            }
                                        });
                                    }, false);

                                    ab.appendChild(ar);
                                    ab.appendChild(aa);
                                    hc.appendChild(ab);
                                });
                            }, false);

                            li.appendChild(hc);
                        }
                    }

                    li.insertBefore(lc, li.firstChild);
                    ul.appendChild(li);
                });
            } catch(e) { console.log(e); }
        });
    },
    panelShow: function() {
        var b = ge('charm-panel'), s = qs('div.side-ui', b);

        setStyle(document.body, {overflow:'hidden'});

        b.classList.remove('no-display');
        setTimeout(function() { setStyle(b, {opacity:1}); }, 100);
        setTimeout(function() { setStyle(s, {right:0}); }, 200);
    },
    panelHide: function() {
        var b = ge('charm-panel'), s = qs('div.side-ui', b);

        setStyle(s, {right:-320});
        setStyle(b, {opacity:0});
        setTimeout(function() {
            b.classList.add('no-display');
            setStyle(document.body, {overflow:'auto'});
        }, 200);
    },
    request: function(method, url, params, el, done) {
        var loader = ce('div', {id:'loader', class:'line-dots-black'}, {position:'absolute', top:0, left:0, backgroundColor:'rgb(255, 255, 255)', width:'100%', height:'100%', zIndex:999});

        console.log(params);
        if (!isObject(params)) return;

        ajax.send(method, url, params, function() {
            if (el) el.appendChild(loader);
        }, function(r) {
            if (el) delete dispose(loader);
            if (isFunction(done)) done(r);
        });
    },
    setAttri: function(params, el) {
        var target = getParent(el, false, 'div'), loader = ce('div', {id:'loader', class:'line-dots-black'}, {position:'absolute', top:0, left:0, width:'100%', height:'100%'});

        if (!isObject(params)) return;

        params.updServices = true;

        ajax.send('POST', 'admin/servermanagement', params, function() {
            setStyle(el, {display:'none'});
            target.appendChild(loader);
        }, function(r) {
            delete dispose(loader);
            el.removeAttribute('style');
        });
    }
};

var Store = {
    showItem: function(el, params) {
        var pc = ge('page-container'),
            pl = ge('page-layout'),
            mb = qs('div.message-box', pl),
            co = function(string) {
                var nl = /(?:\\[r])+/g,
                    hc = /[\u005e><][\w]{6}/g;

                if (string.match(nl)) {
                    string = string.replace(nl, '<br />');
                }

                if (string.match(hc)) {
                    string = string.replace(hc, function(match) {
                        return '<font color="' + match.replace('^', '#') + '">';
                    }) + '</font>';
                }
                return string;
            }, loader = ce('div', {id: 'loader', class:'spinner invert'}, {top:'50%', left:'50%', marginLeft:-30, marginTop:-32});

        if (!isObject(params)) return;

        toggle(pl);

        params.act = 'get_item';
        ajax.send('POST', 'store/ajax', params, function() {
            hide(mb);
            pc.classList.add('blur');
            setStyle(document.body, {overflowY:'hidden'});
            pl.insertBefore(loader, pl.firstChild);
        }, function(r) {
            try {
                var p = JSON.parse(r),
                    h = qs('.message-box-header', mb),
                    c = qs('.message-box-content', mb),
                    f = qs('.message-box-footer', mb);

                setStyle(h, {color:'#' + p.color});
                setStyle(c, {whiteSpace:'pre-wrap'});
                h.textContent = p.name;
                c.innerHTML = co(p.description);

                var lt = ce('div', {class:'left-float'}, {marginTop:3, fontSize:14, lineHeight:34, color:'rgb(255, 255, 0)', textShadow:'1px 1px 0 rgb(0, 0, 0)'}),
                    bb = ce('button', {class:'b-page-shop right-float'}),
                    bc = ce('button', {class:'b-page-shop right-float'});

                bb.addEventListener('click', function () {
                    var ic = ge('item-count'), cl = bb.classList, count = 0, status = qs('.status', f) || ce('div', {class:'status'});

                    if (!p.store_id) return;

                    if (ic != undefined) {
                        count = ic.value;
                    }

                    ajax.send('POST', 'store/ajax', {act:'buy_item', sid:p.store_id, count:count}, function() {
                        cl.add('onload');
                        cl.add('line-dots-black');
                        status.innerHTML = '';
                    }, function(r) {
                        cl.remove('line-dots-black');
                        f.appendChild(status);
                        status.innerHTML = r;

                        setTimeout(function () {
                            cl.remove('onload');
                        }, 3000);
                    });
                }, false);

                bc.addEventListener('mousedown', function() {
                    f.innerHTML = '';
                    pc.classList.remove('blur');
                    document.body.removeAttribute('style');
                    toggle(pl);
                }, false);

                if (p.count_editable == 1) {
                    lt.innerHTML = 'Количество: <input type="number" class="field editable" id="item-count" value="' + p.count + '" onkeyup="Store.updatePrice(this, ' + p.price + ', ' + p.count + ', ' + p.discount + ');" onchange="Store.updatePrice(this, ' + p.price + ', ' + p.count + ', ' + p.discount + ');" min="' + p.count + '" max="' + p.max_count + '" /><i data-icon="&#xe008;" style="margin-top: 6px; margin-left: -24px;" />';
                } else {
                    lt.innerHTML = 'Количество: ' + p.count + '';
                }

                bb.innerHTML = 'Купить за <span id="item-price">' + Math.round(p.price-(p.price / 100 * p.discount)) + '</span> <label id="item-price-declination"></label>';
                bc.innerHTML = 'Закрыть окно';

                f.appendChild(lt);
                f.appendChild(bb);
                f.appendChild(bc);

                declNum(ge('item-price-declination'), price_labels, p.price);
            } catch(e) { console.log(e); }

            setTimeout(function () {
                show(mb);
                delete dispose(loader);
            }, 500);
        });

        return false;
    },
    updatePrice: function(el, price, dv, discount) {
        var val = el.value, pb = ge('item-price'), pl = ge('item-price-declination'), newPrice;

        if (!el || !dv) return;

        if (val > 0) {
            setTimeout(function () {
                newPrice = val*price;
                if (discount > 0) {
                    newPrice = Math.round(newPrice - (newPrice / 100 * discount));
                }

                pb.textContent = newPrice;
                declNum(pl, price_labels, newPrice);
            }, 200);
        } else {
            if (discount > 0) {
                newPrice = Math.round(price - (price / 100 * discount));
            }

            pb.textContent = newPrice;
            el.value = dv;
            declNum(pl, price_labels, price);
        }
    },
    removeItem: function(url, params, el) {
        ajax.send('POST', url, params, function() {
            setStyle(el, {opacity:0.5});
        }, function(r) {
            setStyle(el, {opacity:1});
            el.innerHTML = '<td colspan="' + qsall('td', el).length + '">' + r + '</td>';
        });
    },
    quickEdit: function(url, params, el) {
        if (isObject(params)) {
            params.act = 'item_edit';
            ajax.send('POST', url, params);
        }
    },
    showFilter: function(el, st) {
        var input = qs('input', el), span = qs('span', el);
        setStyle(el, st || {});
        hide(span);
        show(input);

        input.focus();
    },
    hideFilter: function(el, evt, st) {
        if (evt.keyCode == 27 || evt.keyCode == 13) {
            setStyle(el.parentNode, st || {});
            show(qs('span', el.parentNode));
            hide(el);
        }
    },
    addCategory: function(el) {
        var parent = el.parentNode, field = qs('.field', parent), id = ge('category-id'), rt = ce('span'), params = {};

        if(field.value == '') return;

        params.name = field.value;
        if (id.value != '') {
            params.act = 'category_edit';
            params.id = id.value;
        } else {
            params.act = 'category_add';
        }

        ajax.send('POST', 'store/ajax', params, function() {
            setStyle(el, {backgroundColor:'transparent'});
            el.classList.add('line-dots-black');
            field.classList.add('no-display');
        }, function(r) {
            el.removeAttribute('style');
            el.classList.add('no-display');

            rt.innerHTML = r;
            parent.insertBefore(rt, parent.firstChild);

            setTimeout(function() {
                el.classList.remove('no-display');
                el.classList.remove('line-dots-black');

                id.value = '';
                field.value = '';
                field.classList.remove('no-display');
                delete dispose(rt);
                el.parentNode.classList.add('no-display');
                qs('.add-category').classList.remove('no-display');
            }, 3000);
        });
    },
    editCategory: function(id, name) {
        var target = qs('.add-category-form'), field = qs('input[type=text]', target), cid = ge('category-id');

        cid.value = id;
        field.value = name;
        target.classList.remove('no-display');
    },
    countdown: function(date, el) {
        var dateParts = date.match(/(\d+)-(\d+)-(\d+) (\d+):(\d+)/); // ex.: '2015-03-29 22:00'
        var current = new Date(dateParts[1], parseInt(dateParts[2], 10) - 1, dateParts[3], dateParts[4], dateParts[5]);
        var timestamp = (current - Date.now()) / 1000;

        setInterval(function() {
            timestamp--;

            var days    = Math.floor(timestamp / 86400),
                hours   = Math.floor(timestamp / 3600) % 24,
                minutes = Math.floor(timestamp / 60) % 60,
                seconds = Math.floor(timestamp) % 60;

            el.innerHTML = (days > 0 ? days + ' дн., ' : '') + hours + 'ч. ' + minutes + 'м. ' + seconds + 'сек.';

        }, 1000);
    }
};

var Settings = {
    detailed: function(el) {
        var bl = getParent(el, false, 'ul'), els = bl.querySelectorAll('li'), target = getParent(el, false, 'li');

        for (var i = 0; i < els.length; i++) {
            var cl = els[i].classList;
            if (cl.contains('active')) {
                cl.remove('active');
            }
        }

        toggle(target);
    },
    cancelDetailed: function(el) {
        var target = getParent(el, false, 'li');
        toggle(target);
    },
    paramSet: function(id, params, el) {
        var parent = getParent(el, 'hidden-content'), loader = ce('div', {id: 'loader', class:'spinner small'}, {top:10, right:10});
        if (id != '' && isObject(params)) {
            params.act = 'set_' + id;
            ajax.send('POST', 'account/ajax', params, function() {
                el.classList.add('disabled');
                parent.insertBefore(loader, parent.firstChild);
            }, function(text) {
                setStyle(loader, {'background-image':'none', 'width':'auto', top:15});
                loader.innerHTML = '<nobr>' + text + '</nobr>';

                setTimeout(function () {
                    el.classList.remove('disabled');
                    delete dispose(loader);
                }, 2000);
            });
        }
    },
    submitIP: function(id, el) {
        var ip = ge(id).value;
        this.paramSet('ip', {val:ip}, el);
    },
    showEditBox: function(el) {
        var parent = getParent(el, 'hidden-content'), helper = parent.querySelector('div.helper-box'), cl = helper.classList, field = parent.querySelector('input.field');

        if (!cl.contains('active')) {
            cl.add('active');
            el.classList.add('no-display');
            field.classList.remove('naked');
            setStyle(field, 'display', 'inline-block');
        }
    },
    hideEditBox: function(el) {
        var parent = getParent(el, 'hidden-content'), helper = qs('.helper-box', parent), cl = helper.classList, field = qs('.field', parent), a = qs('.no-display', parent);
        if (cl.contains('active')) {
            cl.remove('active');
            field.classList.add('naked');

            setTimeout(function () {
                a.classList.remove('no-display');
            }, 3000);
        }
    },
    openModal: function() {
        var pl = ge('page-layout'), window = ce('div', {class:'settings-window'}), loader = ce('li', {id:'loader', class:'spinner'}, {}), de = document.documentElement;

        setStyle(de, {overflowY:'hidden'});
        toggle(pl);

        pl.appendChild(window);
    }
};

var ajax = {
    init: function() {
        var r = false;
        try {
            if (r = new XMLHttpRequest()) {
                ajax.request = function() {
                    return new XMLHttpRequest();
                };

                return;
            }
        } catch(e) {}
        each(['Msxml2.XMLHTTP', 'Msxml3.XMLHTTP', 'Microsoft.XMLHTTP'], function() {
            try {
                var t = '' + this;
                if (r = new ActiveXObject(t)) {
                    (function(n) {
                        ajax.request = function() { return new ActiveXObject(n); }
                    })(t);
                    return false;
                }
            } catch(e) {}
        });

        if (!ajax.request) {
            // bad browser
        }
    },
    getRequest: function() {
        if (!ajax.request) ajax.init();
        return ajax.request();
    },
    send: function(type, url, query, load, done) {
        var r = ajax.getRequest(), ar2q = function(a) {
            var query = [], encode = function(str) {
                try {
                    return encodeURIComponent(str);
                } catch(e) { return str; }
            };

            for (var key in a) {
                if (a[key] == null) continue;
                if (isArray(a[key])) {
                    for (var i = 0, c = 0, l = a[key].length; i < l; ++i) {
                        if (a[key][i] == null) continue;
                        query.push(encode(key) + '[' + c + ']=' + encode(a[key][i]));
                        ++c;
                    }
                } else {
                    query.push(encode(key) + '=' + encode(a[key]));
                }
            }
            query.sort();
            return query.join('&');
        }, q = {};

        r.onreadystatechange = function() {
            if (r.readyState <= 3) {
                if (isFunction(load)) load();
            } else if (r.readyState == 4) {
                if (r.status >= 200 && r.status < 300) {
                    if (isFunction(done)) done(r.responseText);
                }
            }
        };

        if (type == 'POST') {
            try {
                r.open('POST', url, true);
            } catch(e) { return false; }

            q = (typeof(query) != 'string') ? ar2q(query) : query;
            if (typeof(q) == 'string') {
                r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            }
            r.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            r.send(q);
        } else {
            try {
                q = (typeof(query) != 'string') ? ar2q(query) : query;
                r.open('GET', url + '&' + q, true);
            } catch(e) { return false; }

            r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            r.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            r.send();
        }

        return r;
    }
};

var VMasker = function(){
    var DIGIT = '9';
    var ALPHA = 'A';
    var ALPHANUM = 'S';
    var BY_PASS_KEYS = [8, 9, 16, 17, 18, 36, 37, 38, 39, 40, 91, 92, 93];
    var isAllowedKeyCode = function(keyCode) {
        for (var i = 0, len = BY_PASS_KEYS.length; i < len; i++) {
            if (keyCode == BY_PASS_KEYS[i]) {
                return false;
            }
        }
        return true;
    };

    var VanillaMasker = function(elements) {
        this.elements = elements;
    };

    VanillaMasker.prototype.unbindElementToMask = function() {
        for (var i = 0, len = this.elements.length; i < len; i++) {
            this.elements[i].lastOutput = '';
            this.elements[i].onkeyup = false;
            this.elements[i].onkeydown = false;
            this.elements[i].isVMasker = true;

            if (this.elements[i].value.length) {
                this.elements[i].value = this.elements[i].value.replace(/\D/g, '');
            }
        }
    };

    VanillaMasker.prototype.bindElementToMask = function(maskFunction) {
        var that = this;
        var onType = function(e) {
            var source = e.target || e.srcElement;

            if (isAllowedKeyCode(e.keyCode)) {
                setTimeout(function() {
                    that.opts.lastOutput = source.lastOutput;
                    source.value = VMasker[maskFunction](source.value, that.opts);
                    source.lastOutput = source.value;
                }, 0);
            }
        };

        for (var i = 0, len = this.elements.length; i < len; i++) {
            this.elements[i].lastOutput = '';
            this.elements[i].onkeyup = onType;
            if (this.elements[i].value.length) {
                this.elements[i].value = VMasker[maskFunction](this.elements[i].value, this.opts);
            }
        }
    };

    VanillaMasker.prototype.maskPattern = function(pattern) {
        this.opts = {pattern: pattern};
        this.bindElementToMask('toPattern');
    };

    VanillaMasker.prototype.unMask = function() {
        this.unbindElementToMask();
    };

    var VMasker = function(el) {
        if (!el) {
            console.log('VanillaMasker: There is no element to bind.');
            return;
        }

        var elements = ('length' in el) ? (el.length ? el : []) : [el];
        return new VanillaMasker(elements);
    };

    VMasker.toPattern = function(value, opts) {
        var pattern = (typeof opts === 'object' ? opts.pattern : opts);
        var patternChars = pattern.replace(/\W/g, '');
        var output = pattern.split('');
        var values = value.toString().replace(/\W/g, '');
        var charsValues = values.replace(/\W/g, '');

        for (var i = 0, index = 0; i < output.length; i++) {

            if (index >= values.length) {
                if (patternChars.length == charsValues.length) {
                    return output.join('');
                }
                break;
            }
            if ((output[i] === DIGIT && values[index].match(/[0-9]/)) ||
                (output[i] === ALPHA && values[index].match(/[a-zA-Z]/)) ||
                (output[i] === ALPHANUM && values[index].match(/[0-9a-zA-Z]/))) {
                output[i] = values[index++];
            } else if (output[i] === DIGIT || output[i] === ALPHA || output[i] === ALPHANUM) {
                output = output.slice(0, i);
            }
        }

        return output.join('').substr(0, i);
    };

    /*VMasker.toNumber = function(value) {
        return value.toString().replace(/(?!^-)[^0-9]/g, "");
    };*/

    return VMasker;
}();
