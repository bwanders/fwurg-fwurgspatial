<?php
/**
 * fwurgspatial plugin, route type
 *
 * @author  Brend Wanders <b.wanders@xs4all.nl>
 */

class plugin_strata_type_route extends plugin_strata_type {
    function normalize($value, $hint) {
        $helper = plugin_load('helper', 'fwurgspatial');
        $route = $helper->parse_route($value);
        if($route != null) {
            $parts = array();
            foreach($route as $sector) {
                $parts[] = "$sector[0] $sector[1]";
            }
            return implode(' : ', $parts);
        } else {
            return $value;
        }
    }

    function render($mode, &$R, &$T, $value, $hint) {
        if($mode == 'xhtml') {
            $helper = plugin_load('helper', 'fwurgspatial');

            $route = $helper->parse_route($value);
            if($route != null) {
                $icons_helper = plugin_load('helper', 'fwurgicons');
                $icons_syntax = plugin_load('syntax', 'fwurgicons');
                $sector_icon = $icons_helper->getIcon('sector'); //fixme: route icon

                $icons_syntax->render($mode, $R, $sector_icon);
                $first = true;
                foreach($route as $sector) {
                    if(!$first) {
                        $R->doc .= ' <span class="fwurgspatial_route_connector">»</span> ';
                    }
                    $R->doc .= " $sector[0] $sector[1]";
                    $first = false;
                }                
            } else {
                $R->doc .= $R->_xmlEntities($value);
            }
            return true;
        }

        return false;
    }

    function getInfo() {
        return array(
            'desc'=>'A route through multiple sectors.',
            'tags'=>array(),
            //'hint'=>''
        );
    }
}
