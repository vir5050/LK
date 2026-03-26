<?php
/**
 * StoreController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class StoreController extends CController
{
	/**
	 * Class default constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->view->response = '';
		$this->view->actionMessage = '';
	}

	/**
	 * Controller default action handler
	 */
	public function indexAction()
	{
		CAuth::handleLogin('user/login');

		/** @var Store $model */
		$model = Store::model();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$mask = $request->getQuery('mask', 'integer');
		$category = $request->getQuery('category', 'integer', 0);

		if(CValidator::isInteger($mask)){
			$count = $model->countByAttributes(array('mask'=>$mask));
			if($count > 0){
				$this->view->subhead = My::t('app', 'maskNames.'.$mask);
				$attributes = array('for_sale'=>1, 'mask'=>$mask);
				$condition = 'for_sale = :for_sale AND mask = :mask';
				$params = array(':for_sale'=>1, ':mask'=>$mask);
			}else{
				$this->view->subhead = My::t('app', 'Featured items');
				$attributes = array('for_sale'=>1);
				$condition = 'for_sale = :for_sale';
				$params = array(':for_sale'=>1);
			}
		}elseif(!empty($category)){
			$category = Category::model()->findByPk($category);
			if($category !== null){
				$this->view->subhead = $category->name;
				$category = $category->category_id;
				$attributes = array('for_sale'=>1, 'category'=>$category);
				$condition = 'for_sale = :for_sale AND category = :category';
				$params = array(':for_sale'=>1, ':category'=>$category);
			}else{
				$this->view->subhead = My::t('app', 'Featured items');
				$attributes = array('for_sale'=>1);
				$condition = 'for_sale = :for_sale';
				$params = array(':for_sale'=>1);
			}
		}else{
			$this->view->subhead = My::t('app', 'Featured items');
			$attributes = array('for_sale'=>1);
			$condition = 'for_sale = :for_sale';
			$params = array(':for_sale'=>1);
		}

		$this->view->categories = Category::model()->findAll();
		$this->view->targetPath = 'store/index'.(!empty($category) ? '/category/'.$category : '');
		$this->view->pageSize = 12;
		$this->view->currentPage = $request->getQuery('page', 'integer', 1);
		$this->view->totalRecords = $model->countByAttributes($attributes);
		$this->view->allItems = $model->findAll(array('condition'=>$condition, 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'total_sales DESC, store_id DESC'), $params);
		$this->view->setMetaTags('title', My::t('app', 'Store').' :: '.$this->view->subhead);
		$this->view->render('store/index', $request->isAjaxRequest());
	}

	/**
	 * Store admin action handler
	 */
	public function adminAction()
	{
		if(!CAuth::isLoggedInAsAdmin()){
			$this->redirect('index/index');
		}

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var Store $model */
		$model = Store::model();
		$filterId = $request->getQuery('filterId');
		$filterName = $request->getQuery('filterName');
		$filterMask = $request->getQuery('filterMask');
		if($filterId != ''){
			$condition = 'item_id = :item_id';
			$params = array(':item_id'=>$filterId);
		}elseif($filterName != ''){
			$condition = 'name like :name';
			$params = array(':name'=>'%'.$filterName.'%');
		}elseif($filterMask != ''){
			$condition = 'mask = :mask';
			$params = array(':mask'=>$filterMask);
		}else{
			$condition = '';
			$params = array();
		}

		$this->view->targetPath = 'store/admin'.($filterName != '' ? '/filterName/'.$filterName : '').($filterMask != '' ? '/filterMask/'.$filterMask : '');
		$this->view->pageSize = 20;
		$this->view->currentPage = $request->getQuery('page', 'integer', 1);
		$this->view->totalRecords = $model->count($condition, $params);
		$this->view->storeItems = $model->findAll(array('condition'=>$condition, 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'for_sale DESC, store_id ASC'), $params);

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}

		$this->view->setMetaTags('title', My::t('app', 'Store'));
		$this->view->render('store/admin', $request->isAjaxRequest());
	}

	/**
	 * Store import action handler
	 */
	public function importAction()
	{
		if(!CAuth::isLoggedInAsAdmin()){
			$this->redirect('index/index');
		}

		$absPath = APP_PATH.DS.'uploads'.DS;
		$zipFile = $absPath.'import.zip';
		if(file_exists($zipFile)){
			if(!class_exists('ZipArchive')) exit('Class \'ZipArchive\' not found');
			$zip = new ZipArchive;
			if($zip->open($zipFile) === true){
				$zip->extractTo($absPath);
				$zip->close();

				$db = CDatabase::init();
				$db->delete('store', 'for_sale = 0');

				$file = file($absPath.'UdE_Exported_Table.tab');
				foreach($file as $item){
					$addons = '';
					$buffer = explode("\t", $item);
					/*$store = new Store;
					$store->item_id = $buffer[0];
					$store->color = $buffer[1];
					$store->name = $buffer[2];
					$store->description = $buffer[3];
					$store->max_count = $buffer[4];
					$store->proctype = $buffer[5];
					$store->mask = $buffer[6];
					$store->save();*/

					$db->insert('store', array(
						'item_id'=>$buffer[0],
						'color'=>$buffer[1],
						'name'=>$buffer[2],
						'description'=>$buffer[3],
						'max_count'=>$buffer[4],
						'proctype'=>$buffer[5],
						'mask'=>$buffer[6]
					));
				}

				$this->redirect('store/admin');
			}else{
				exit('can\'t open .zip');
			}
		}else{
			exit('import.zip archive not found');
		}
	}

	/**
	 * Store edit action handler
	 */
	public function editAction()
	{
		if(!CAuth::isLoggedInAsAdmin()){
			$this->redirect('index/index');
		}

		/** @var Store $model */
		$model = Store::model();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		if($request->getPost('act') == 'save'){
			$storeId = $request->getPost('store_id');
			$item = $model->findByPk($storeId);
			$item->name = $request->getPost('name');
			$item->description = $request->getPost('description');
			$item->price = $request->getPost('price');
			$item->discount = $request->getPost('discount');
			$item->count = $request->getPost('count');
			$item->max_count = $request->getPost('max_count');
			$item->octet = $request->getPost('octet');
			$item->mask = $request->getPost('mask');
			$item->proctype = $request->getPost('proctype');
			$item->expire_date = $request->getPost('expire_date');
			$item->count_editable = ($request->getPost('count_editable') !== '') ? $request->getPost('count_editable') : 0;
			$item->shareable = ($request->getPost('shareable') !== '') ? $request->getPost('shareable') : 0;
			$item->for_sale = ($request->getPost('for_sale') !== '') ? $request->getPost('for_sale') : 0;
			$item->category = $request->getPost('category');

			if($item->save()){
				$msg = My::t('app', 'Successfully');
				$messageType = 'success';
			}else{
				$msg = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		$id = $request->getQuery('id');
		if(!empty($id)){
			$result = $model->findByPk($id);
			if($result!==null){
				$this->view->item = $model->getFieldsAsArray();
			}

			$this->view->proctypes = '';
			$itemProctype = Store::proctype($result->proctype);
			foreach((array)My::t('app', 'proctype') as $key => $value){
				$checked = (in_array($key, $itemProctype) ? ' checked' : '');
				$this->view->itemProctype .= '<input type="checkbox" class="checkbox" value="'.$key.'" onchange="calculateProctype();" data-st="item-proctype" id="item-proctype-id-'.$key.'"'.$checked.' /><label for="item-proctype-id-'.$key.'" class="icon-checkbox">'.$value.'</label>';
			}
		}

		$categories = array(0=>'---');
		$cats = Category::model()->findAll();
		foreach($cats as $category){
			$categories[$category['category_id']] = $category['name'];
		}

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}

		$this->view->categories = $categories;
		$this->view->render('store/edit', $request->isAjaxRequest());
	}

	/**
	 * Store additem action handler
	 */
	public function additemAction()
	{
		if(!CAuth::isLoggedInAsAdmin()){
			$this->redirect('index/index');
		}

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'send'){
			$this->view->item_id = $request->getPost('item_id');
			$this->view->name = $request->getPost('name');
			$this->view->description = $request->getPost('description');
			$this->view->price = $request->getPost('price');
			$this->view->discount = $request->getPost('discount');
			$this->view->count = $request->getPost('count');
			$this->view->octet = $request->getPost('octet');
			$this->view->proctype = $request->getPost('proctype');
			$this->view->mask = $request->getPost('mask');
			$this->view->expire_date = $request->getPost('expire_date');
			$this->view->count_editable = ($request->getPost('count_editable') !== '') ? $request->getPost('count_editable') : 0;
			$this->view->shareable = ($request->getPost('shareable') !== '') ? $request->getPost('shareable') : 0;
			$this->view->for_sale = ($request->getPost('for_sale') !== '') ? $request->getPost('for_sale') : 0;
			$this->view->category = $request->getPost('category');

			$store = new Store;
			$store->item_id = $this->view->item_id;
			$store->name = $this->view->name;
			$store->description = $this->view->description;
			$store->price = $this->view->price;
			$store->discount = $this->view->discount;
			$store->count = $this->view->count;
			$store->octet = $this->view->octet;
			$store->proctype = $this->view->proctype;
			$store->mask = $this->view->mask;
			$store->expire_date = $this->view->expire_date;
			$store->count_editable = $this->view->count_editable;
			$store->shareable = $this->view->shareable;
			$store->for_sale = $this->view->for_sale;
			$store->category = $this->view->category;

			if($store->save()){
				$msg = My::t('app', 'Successfully');
				$messageType = 'success';
			}else{
				$msg = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		$this->view->proctypes = '';
		$itemProctype = Store::proctype($this->view->proctype);
		foreach((array)My::t('app', 'proctype') as $key => $value){
			$checked = (in_array($key, $itemProctype) ? ' checked' : '');
			$this->view->itemProctype .= '<input type="checkbox" class="checkbox" value="'.$key.'" onchange="calculateProctype();" data-st="item-proctype" id="item-proctype-id-'.$key.'"'.$checked.' /><label for="item-proctype-id-'.$key.'" class="icon-checkbox">'.$value.'</label>';
		}

		$categories = array(0=>'---');
		$cats = Category::model()->findAll();
		foreach($cats as $category){
			$categories[$category['category_id']] = $category['name'];
		}

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}

		$this->view->categories = $categories;
		$this->view->render('store/additem', $request->isAjaxRequest());
	}

	/**
	 * Store ajax action handler
	 */
	public function ajaxAction()
	{
		/** @var Store $model */
		$model = Store::model();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->isAjaxRequest()){
			switch($request->getPost('act')){
				case 'get_item':
					if(CAuth::isGuest()) exit;

					$storeId = $request->getPost('sid');
					if(CValidator::isInteger($storeId)){
						$item = $model->findByPk($storeId);
						if($item !== null){
							$result = json_encode($model->getFieldsAsArray());
							$this->view->response = $result;
						}
					}
					break;
				case 'buy_item':
					if(CAuth::isGuest()) exit;

					sleep(2);

					$storeId = $request->getPost('sid');
					$count = $request->getPost('count', 'integer', 0);
					$roleId = CAuth::getLoggedParam('selectedRoleId');
					if(CValidator::isInteger($storeId) and CValidator::isInteger($count)){
						if(!empty($roleId)){
							$item = $model->findByPk($storeId);
							if($item !== null and $item->for_sale == 1){
								$user = User::model()->findByPk(CAuth::getLoggedId());
								if($item->count_editable == 1){
									if($count < $item->count){
										$count = $item->count;
									}elseif($count > $item->max_count){
										$count = $item->max_count;
									}
								}else{
									$count = $item->count;
								}
								
								$totalPrice = self::calculateTotalPrice($item, $count);
								if($totalPrice > $user->coins){
									$this->view->response = My::t('app', 'Not enough coins');
								}else{
									$user->coins = $user->coins - $totalPrice;
									if ($user->save()) {
										/** @var CCurl $curl */
										$curl = My::app()->getCurl();
										$result = $curl->run(CConfig::get('apiUrl').'server/sendMail', array(
											'receiver'=>$roleId,
											'title'=>'MyWeb Store',
											'context'=>My::t('app', 'Thank you for your purchase!'),
											'attach_obj'=>json_encode(array(
												'id'=>$item->item_id,
												'pos'=>0,
												'count'=>$count,
												'max_count'=>$item->max_count,
												'data'=>$item->octet,
												'proctype'=>$item->proctype,
												'expire_date'=>($item->expire_date > 0) ? time() + $item->expire_date : 0,
												'guid1'=>0,
												'guid2'=>0,
												'mask'=>$item->mask,
											)),
											'attach_money'=>0
										))->getData(true);

										if($result['status'] == 1){
											$item->total_sales = $item->total_sales+1;
											$item->last_buy_time = time();
											$item->last_buy_character = CAuth::getLoggedParam('selectedRoleName');
											$item->save();

											$this->view->response = My::t('app', 'Successfully');
										}else{
											$this->view->response = My::t('app', 'Failed');
										}

										$log = new StoreLog;
										$log->account_id = CAuth::getLoggedId();
										$log->store_id = $item->store_id;
										$log->ip_address = CIp::getBinaryIp();
										$log->request_date = time();
										$log->request_data = json_encode(array('count'=>$count, 'total_price'=>$totalPrice, 'receiver'=>$roleId));
										$log->save();
									} else {
										$this->view->response = My::t('app', 'Failed');
									}
								}
							}
						}else{
							$this->view->response = My::t('app', 'Character not selected');
						}
					}
					break;
				case 'item_remove':
					if(!CAuth::isLoggedInAsAdmin()){
						$this->redirect('index/index');
					}

					$storeId = $request->getPost('sid');
					if(!empty($storeId)){
						$result = $model->deleteByPk($storeId);
						if($result){
							$this->view->response = My::t('app', 'Successfully');
						}else{
							$this->view->response = My::t('app', 'Failed');
						}
					}
					break;
				case 'item_edit':
					if(!CAuth::isLoggedInAsAdmin()){
						$this->redirect('index/index');
					}

					$storeId = $request->getPost('sid');
					$key = $request->getPost('key');
					$value = $request->getPost('val');
					$item = $model->findByPk($storeId);

					if($item!==null){
						$item->$key = $value;
						$item->save();
					}
					break;
				case 'category_add':
					if(!CAuth::isLoggedInAsAdmin()){
						$this->redirect('index/index');
					}

					$name = $request->getPost('name');
					if(CValidator::validateMaxLength($name, 50)){
						$exists = Category::model()->findByAttributes(array('name'=>$name));
						if($exists===null){
							$category = new Category;
							$category->name = $name;
							$category->save();

							$this->view->response = My::t('app', 'Successfully');
						}else{
							$this->view->response = My::t('app', 'Failed');
						}
					}else{
						$this->view->response = My::t('core', 'max.: {maxchars} chars', array('{maxchars}'=>50));
					}
					break;
				case 'category_edit':
					if(!CAuth::isLoggedInAsAdmin()){
						$this->redirect('index/index');
					}

					$id = $request->getPost('id');
					$name = $request->getPost('name');
					if(CValidator::validateMaxLength($name, 50) and CValidator::isInteger($id)){
						$category = Category::model()->findByPk($id);
						if($category !== null){
							$category->name = $name;
							$category->save();

							$this->view->response = My::t('app', 'Successfully');
						}else{
							$this->view->response = My::t('app', 'Failed');
						}
					}else{
						$this->view->response = My::t('core', 'max.: {maxchars} chars', array('{maxchars}'=>50));
					}
					break;
				case 'category_remove':
					if(!CAuth::isLoggedInAsAdmin()){
						$this->redirect('index/index');
					}

					$id = $request->getPost('id');
					if(CValidator::isInteger($id)){
						if($request->isPostExists('save')){
							for(;;){
								if($model->countByAttributes(array('category'=>$id)) == 0){
									break;
								}

								$item = $model->findByAttributes(array('category'=>$id));
								$item->category = 0;
								$item->save();
							}
						}else{
							$model->deleteAll('category = :category', array(':category'=>$id));
						}

						$result = Category::model()->deleteByPk($id);
						if($result){
							$this->view->response = '1';
						}
					}
					break;
				default:
					break;
			}
		}

		if($request->getQuery('proctype') != ''){
			$proctype = $request->getQuery('proctype');
			$this->view->response = Store::proctype($proctype, true);
		}

		if($request->getQuery('expire') != ''){
			$expire = $request->getQuery('expire');
			$this->view->response = CTime::convertSecondsToTime($expire);
		}

		if($request->getQuery('findById') != ''){
			$id = $request->getQuery('findById');
			if(CValidator::isInteger($id)){
				if(null !== ($item = $model->findByAttributes(array('item_id'=>$id)))){
					$this->view->response .= $item->color."\t".$item->name;
				}
			}
		}

		if($request->getQuery('preview') != ''){
			$this->view->response = '';
			$nl = '<br />';
			$s = ' ';
			$id = $request->getQuery('preview');
			$data = $request->getQuery('octet');
			if(CValidator::isInteger($id)){
				if(null !== ($item = $model->findByPk($id))){
					$data = !empty($data) ? $data : $item->octet;
					if($data != '' and ctype_xdigit($data)){
						if(in_array($item->mask, array(1, 2, 4, 8, 16, 32, 64, 128, 256, 1536, 1073741825))){
							$octet = COctet::readItemoctet($data);
							if($octet!==null){
								$this->view->response .= '<strong style="color:#'.$item->color.';">'.$item->name.($item->count > 1 ? ' x'.$item->count : '').($octet['stones']['cell_count'] > 0 ? ' ('.My::t('app', 'cells').': '.$octet['stones']['cell_count'].')' : '').'</strong>'.$nl;
								if($octet['preq']['tag_type'] == 36){
									if($item->mask == 1536){
										if($octet['essence']['defense'] > 0){
											$this->view->response .= My::t('app', 'Physical damage').$s.'+'.$octet['essence']['defense'].$nl;
										}
										if($octet['essence']['armor'] > 0){
											$this->view->response .= My::t('app', 'Magic damage').$s.'+'.$octet['essence']['armor'].$nl;
										}
									}else{
										if($octet['essence']['defense'] > 0){
											$this->view->response .= My::t('app', 'Defense').$s.$octet['essence']['defense'].$nl;
										}
										if($octet['essence']['armor'] > 0){
											$this->view->response .= My::t('app', 'Armor').$s.$octet['essence']['armor'].$nl;
										}
									}
									if($octet['essence']['mp_enhance'] > 0){
										$this->view->response .= My::t('app', 'Mana').$s.'+'.$octet['essence']['mp_enhance'].$nl;
									}
									if($octet['essence']['hp_enhance'] > 0){
										$this->view->response .= My::t('app', 'Health').$s.'+'.$octet['essence']['hp_enhance'].$nl;
									}
									if($octet['essence']['metal_resistance'] > 0){
										$this->view->response .= My::t('app', 'Metal resistance').$s.'+'.$octet['essence']['metal_resistance'].$nl;
									}
									if($octet['essence']['wood_resistance'] > 0){
										$this->view->response .= My::t('app', 'Wood resistance').$s.'+'.$octet['essence']['wood_resistance'].$nl;
									}
									if($octet['essence']['water_resistance'] > 0){
										$this->view->response .= My::t('app', 'Water resistance').$s.'+'.$octet['essence']['water_resistance'].$nl;
									}
									if($octet['essence']['fire_resistance'] > 0){
										$this->view->response .= My::t('app', 'Fire resistance').$s.'+'.$octet['essence']['fire_resistance'].$nl;
									}
									if($octet['essence']['earth_resistance'] > 0){
										$this->view->response .= My::t('app', 'Earth resistance').$s.'+'.$octet['essence']['earth_resistance'].$nl;
									}
								}elseif($octet['preq']['tag_type'] == 44){
									$attackSpeed = round(20 / $octet['essence']['attack_speed'], 2);
									$this->view->response .= My::t('app', 'Level').$s.$octet['essence']['weapon_level'].$nl;
									$this->view->response .= My::t('app', 'Attack speed (per second)').$s.(CValidator::isInteger($attackSpeed) ? $attackSpeed.'.00' : $attackSpeed).$nl;
									$this->view->response .= My::t('app', 'Attack range').$s.$octet['essence']['attack_range'].$nl;
									if($octet['essence']['attack_short_range'] > 0){
										$this->view->response .= My::t('app', 'Distance fragility').$s.$octet['essence']['attack_short_range'].$nl;
									}
									if($octet['essence']['damage_low'] > 0 and $octet['essence']['damage_high'] > 0){
										$this->view->response .= My::t('app', 'Physical damage').$s.$octet['essence']['damage_low'].'-'.$octet['essence']['damage_high'].$nl;
									}
									if($octet['essence']['magic_damage_low'] > 0 and $octet['essence']['magic_damage_high'] > 0){
										$this->view->response .= My::t('app', 'Magic damage').$s.$octet['essence']['magic_damage_low'].'-'.$octet['essence']['magic_damage_high'].$nl;
									}
								}
								if($octet['preq']['tag_type'] == 36 or $octet['preq']['tag_type'] == 44){
									$this->view->response .= My::t('app', 'Durability').$s.substr($octet['preq']['durability'], 0, -2).'/'.substr($octet['preq']['max_durability'], 0, -2).$nl;
									if($octet['preq']['race'] > 0 and $octet['preq']['race'] < 1023){
										$this->view->response .= My::t('app', 'Restriction:').$s.Store::classes($octet['preq']['race'], true).$nl;
									}
									if($octet['preq']['level'] > 0){
										$this->view->response .= My::t('app', 'Required level:').$s.$octet['preq']['level'].$nl;
									}
									if($octet['preq']['strength'] > 0){
										$this->view->response .= My::t('app', 'Required strength:').$s.$octet['preq']['strength'].$nl;
									}
									if($octet['preq']['vitality'] > 0){
										$this->view->response .= My::t('app', 'Required vitality:').$s.$octet['preq']['vitality'].$nl;
									}
									if($octet['preq']['agility'] > 0){
										$this->view->response .= My::t('app', 'Required agility:').$s.$octet['preq']['agility'].$nl;
									}
									if($octet['preq']['energy'] > 0){
										$this->view->response .= My::t('app', 'Required energy:').$s.$octet['preq']['energy'].$nl;
									}
									if($octet['addons']['count'] > 0){
										$this->view->response .= '<span style="display: block; margin-top: 2px; color: rgb(114, 114, 240);">';
										for($i = 0, $cell = 0; $i < $octet['addons']['count']; $i++){
											if($octet['addons'][$i]['type'] == 'bonus4'){
												$this->view->response .= '<span style="display: block; color: rgb(255, 220, 80);">';
												$this->view->response .= $octet['addons'][$i]['title'];
												$this->view->response .= '</span>';
											}elseif($octet['addons'][$i]['type'] == 'ability'){
												$this->view->response .= '<span style="font-weight: bold; display: block; color: rgb(239, 80, 48);">';
												$this->view->response .= $octet['addons'][$i]['title'];
												$this->view->response .= '</span>';
											}elseif($octet['addons'][$i]['type'] == 'stone'){
												$stone = $model->findAll('item_id = :id', array(':id'=>$octet['stones']['cells'][$cell]['id']));
												$this->view->response .= '<span style="font-weight: 500;font-family: \'Helvetica Neue\', Helvetica, Arial, \'lucida grande\',tahoma,verdana,arial,sans-serif; display: block; color: rgb(0, 255, 255);">';
												$this->view->response .= (empty($stone[0]['name']) ? My::t('app', 'Stone') : $stone[0]['name']).$s.$octet['addons'][$i]['title'];
												$this->view->response .= '</span>';
												$cell++;
											}else{
												$this->view->response .= $octet['addons'][$i]['title'].$nl;
											}
										}
										$this->view->response .= '</span>';
									}
									if(isset($octet['preq']['tag_content']) and !empty($octet['preq']['tag_content'])){
										$this->view->response .= '<span style="font-weight: bold; display: block; margin: 2px 0 4px; color: #33FF00;">'.My::t('app', 'Creator:').$s.$octet['preq']['tag_content'].'</span>';
									}
									if($item->proctype > 0){
										$this->view->response .= '<span style="display: block; margin-top: 2px; color: rgb(0, 255, 255);">';
										$this->view->response .= Store::proctype($item->proctype, true);
										$this->view->response .= '</span>';
									}
									if($item->description !== ''){
										if(strpos($item->description, '\r') !== false){
											$item->description = preg_replace('#(\\\r)#', '<br />', $item->description);
										}
										if(strpos($item->description, '^') !== false){
											$item->description = preg_replace('#(\\#[\w]{6})#', '<font color="\1">', str_replace('^', '#', $item->description));
										}
										$this->view->response .= $item->description;
									}
								}
							}
						}elseif($item->mask == 8388608){
							COctet::prepareRead($data);
							$elf = COctet::binaryRead(COctet::$_elf);
							$this->view->response = '<strong style="color:#'.$item->color.';">'.$item->name.($item->count > 1 ? ' x'.$item->count : '').'</strong>'.$nl;
							$this->view->response .= My::t('app', 'Level').':'.$s.$elf['level'].$nl;
							$this->view->response .= My::t('app', 'Strength:').$s.$elf['strength'].$nl;
							$this->view->response .= My::t('app', 'Vitality:').$s.$elf['vitality'].$nl;
							$this->view->response .= My::t('app', 'Agility:').$s.$elf['agility'].$nl;
							$this->view->response .= My::t('app', 'Energy:').$s.$elf['energy'].$nl;
							$this->view->response .= My::t('app', 'Total genius:').$s.$elf['total_genius'].$nl;
							if($item->proctype > 0){
								$this->view->response .= '<span style="display: block; margin-top: 2px; color: rgb(0, 255, 255);">';
								$this->view->response .= Store::proctype($item->proctype, true);
								$this->view->response .= '</span>';
							}
						}else{
							$this->view->response = '<strong style="color:#'.$item->color.';">'.$item->name.($item->count > 1 ? ' x'.$item->count : '').'</strong>'.$nl;
							if($item->description !== ''){
								if(strpos($item->description, '\r') !== false){
									$item->description = preg_replace('#(\\\r)#', '<br />', $item->description);
								}
								if(strpos($item->description, '^') !== false){
									$item->description = preg_replace('#(\\#[\w]{6})#', '<font color="\1">', str_replace('^', '#', $item->description));
								}
								$this->view->response .= $item->description;
								if($item->proctype > 0){
									$this->view->response .= '<span style="display: block; margin-top: 2px; color: rgb(0, 255, 255);">';
									$this->view->response .= Store::proctype($item->proctype, true);
									$this->view->response .= '</span>';
								}
							}else{
								$this->view->response .= My::t('app', 'Preview not available');
							}
						}
					}else{
						$this->view->response = '<strong style="color:#'.$item->color.';">'.$item->name.($item->count > 1 ? ' x'.$item->count : '').'</strong>'.$nl;
						if($item->description !== ''){
							if(strpos($item->description, '\r') !== false){
								$item->description = preg_replace('#(\\\r)#', '<br />', $item->description);
							}
							if(strpos($item->description, '^') !== false){
								$item->description = preg_replace('#(\\#[\w]{6})#', '<font color="\1">', str_replace('^', '#', $item->description));
							}
							$this->view->response .= $item->description;
							if($item->proctype > 0){
								$this->view->response .= '<span style="display: block; margin-top: 2px; color: rgb(0, 255, 255);">';
								$this->view->response .= Store::proctype($item->proctype, true);
								$this->view->response .= '</span>';
							}
						}else{
							$this->view->response .= My::t('app', 'Preview not available');
						}
					}
				}
			}
		}

		exit($this->view->response);
	}

	/**
	 * @param $item
	 * @param $count
	 * @return integer
	 */
	private function calculateTotalPrice($item, $count = 0)
	{
		if($item->count_editable == 1){
			$totalPrice = $count * $item->price;
			if($item->discount > 0){
				$totalPrice = round($totalPrice - ($totalPrice / 100 * $item->discount));
			}
		}else{
			if($item->discount > 0){
				$totalPrice = round($item->price - ($item->price / 100 * $item->discount));
			}else{
				$totalPrice = $item->price;
			}
		}

		return $totalPrice;
	}
}