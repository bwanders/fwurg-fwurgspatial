<?php
/**
 * fwurgspatial, helper component
 *
 * @author  Brend Wanders <b.wanders@xs4all.nl>
 */

if (!defined('DOKU_INC')) die('meh.');

/**
 * Helper plugin for common syntax parsing and spatial primitive mangling.
 */
class helper_plugin_fwurgspatial extends DokuWiki_Plugin {
    function parse_sector($value) {
        # drop nonsense
        $value = trim($value);

        # try to parse sector format
        if(preg_match('/^(-?[0-9]+) (-?[0-9]+)$/', $value, $m)) {
            return array($m[1], $m[2]);
        } else {
            return null;
        }
    }

    function parse_route($value) {
        # split into separate sectors
        $parts = split(':', $value);
        $steps = array();
        foreach($parts as $part) {
            $sector = $this->parse_sector(trim($part));
            if($sector == null) return null;
            $steps[] = $sector;
        }
        return $steps;
    }
}
