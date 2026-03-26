<?php
/**
 * CMenu widget helper class file
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------               ----------                  ----------
 * init
 *
 */

class CMenu
{
    const NL = "\n";

    /**
     * Draws menu
     * @param array $links
     * @return string
     */
    public static function init($links = array())
    {
        $output = '';
        $class = 'user-menu';
        $parentTag = 'ul';
        $childTag = 'li';
        $htmlOptions = array('class'=>$class);

        if(is_array($links) and count($links) > 0){
            $output .= CHtml::openTag($parentTag, $htmlOptions).self::NL;
            foreach($links as $key => $link){
                $id = $link['menu_id'];
                $url = $link['external_url'];
                $label = (!empty($link['icon']) ? '<i data-icon="&#x'.$link['icon'].';"></i> ' : '').$link['title'];
                $chHtmlOptions['class'] = 'left-float _h no-border';
                if(CAuth::isLoggedInAsAdmin()){
                    $chHtmlOptions['role'] = 'button';
                    $chHtmlOptions['tabindex'] = '0';
                    $chHtmlOptions['oncontextmenu'] = 'this.focus(); return false;';
                }
                $output .= CHtml::openTag($childTag, $chHtmlOptions).self::NL;
                if(!empty($url)){
                    $output .= CHtml::link($label, $url, array('target'=>'_blank'));
                }else{
                    $output .= CHtml::link($label, 'menu/node/id/'.$id, array('onclick'=>'return go(this, event);'));
                }

                if(CAuth::isLoggedInAsAdmin()){
                    $output .= '<div class="toggle-flyout left light-ui">
                            <ul class="user-navigation">
                                <li><a href="menu/admin/id/'.$id.'" class="sub-link">'.My::t('app', 'Edit').'</a></li>
                                <li><a href="javascript:;" onclick="ajax.send(\'POST\', \'menu/remove\', {id:'.$id.'}, null, function(r) { if (r == 1) location.reload(); });" class="sub-link">'.My::t('app', 'Delete').'</a></li>
                            </ul>
                        </div>';
                }

                $output .= CHtml::closeTag($childTag).self::NL;
            }
            $output .= CHtml::closeTag($parentTag).self::NL;
        }

        return $output;
    }
}