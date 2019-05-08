<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Print the javascript
 *
 * @param  string  $textarea  Arry with the name of textareas to turn in xinha area
 * @return  script javascript for enable xinha text area
 */
function javascript_xihna( $textarea )
{
        $obj =& get_instance();
        $base = $obj->config->item('base_url', 1);
        ob_start();
?>
        <script type="text/javascript">
        _editor_url  = "http://localhost/itm/xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
        _editor_lang = "en";      // And the language we need to use in the editor.
        </script>
        <script type="text/javascript" src="http://localhost/itm/xinha/htmlarea.js"></script>
        <link rel="StyleSheet" href="http://localhost/itm/xinha/skins/xp-green/skin.css" type="text/css">
        <script type="text/javascript" >
                xinha_editors = null;
            xinha_init    = null;
            xinha_config  = null;
            xinha_plugins = null;
            // This contains the names of textareas we will make into Xinha editors
            xinha_init = xinha_init ? xinha_init : function()
            {
             
              xinha_plugins = xinha_plugins ? xinha_plugins :
              [
               'CharacterMap',
               'ContextMenu',
               'FullScreen',
               'ListType',
               'ImageManager',
               'TableOperations'
              ];
                 // THIS BIT OF JAVASCRIPT LOADS THE PLUGINS, NO TOUCHING  :)
                 if(!HTMLArea.loadPlugins(xinha_plugins, xinha_init)) return;
              /** STEP 2 ***************************************************************
               * Now, what are the names of the textareas you will be turning into
               * editors?
               ************************************************************************/
              xinha_editors = xinha_editors ? xinha_editors :
              [
                
                <?
                $area='';
                foreach ($textarea as $item){
                        $area.= "'$item',";
                }
                $area=substr($area,0,-1);
                echo $area;
                ?>
              ];
             
                       xinha_config = xinha_config ? xinha_config() : new HTMLArea.Config();
                    xinha_config.pageStyle = 'body { font-family: verdana,arial,sans-serif; font-size: .9em; }';
                      xinha_editors   = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
                        
              HTMLArea.startEditors(xinha_editors);
            }
            window.onload = xinha_init;
        </script>
<?
        $r = ob_get_contents();
        ob_end_clean(); 
        return $r;
}

/**
 * Return the content of xinha with the absolute path of the image
 *
 * @param  string  $textarea  Name of textarea to turn in xinha area
 * @return  the content of xinha with the absolute path of the image
 */
function return_xihna( $textarea ){
        $obj =& get_instance();
        $baseurl = $obj->config->item('base_url', 1);
        return str_replace('src=\"','src=\"'.$baseurl,$textarea);
}
?>
