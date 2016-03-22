<?php
/**
 * fwurgspatial plugin, sector type
 *
 * @author  Brend Wanders <b.wanders@xs4all.nl>
 */

class plugin_strata_type_sector extends plugin_strata_type {
    function normalize($value, $hint) {
        $helper = plugin_load('helper', 'fwurgspatial');
        $sector = $helper->parse_sector($value);
        if($sector != null) {
            return "$sector[0] $sector[1]";
        } else {
            return $value;
        }
    }

    function render($mode, &$R, &$T, $value, $hint) {
        if($mode == 'xhtml') {
            $helper = plugin_load('helper', 'fwurgspatial');

            $sector = $helper->parse_sector($value);
            if($sector != null) {
                $icons_helper = plugin_load('helper', 'fwurgicons');
                $icons_syntax = plugin_load('syntax', 'fwurgicons');

                $sector_icon = $icons_helper->getIcon('sector');
                $icons_syntax->render($mode, $R, $sector_icon);
                $R->doc .= " $sector[0] $sector[1]";
            } else {
                $R->doc .= $R->_xmlEntities($value);
            }
            return true;
        }

        return false;
    }

    function getInfo() {
        return array(
            'desc'=>'A single sector coordinate, useful as a location of something.',
            'tags'=>array(),
            //'hint'=>''
        );
    }
}
