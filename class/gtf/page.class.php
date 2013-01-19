<?php

/**
 * # Sample usage of gtf\Page: 
 * 
 * Using gtf\Page is quite easy. Just replace your `include($template_file_name)` as the following code.
 *
 * ``` 
 * $page = new gtf\Page;
 * $page->template($template_file_name, $variables);
 * ```
 *
 * Then the template class will find the $template_file_name according to PHP's 'include' convention and render the included template file.
 *
 * ## Method in template file
 *
 * -  `$this->ext($base_template)` to extend the base template.
 * -  `$this->inc($anthor_template)` to include another template.
 * -  `$this->block('block_name') ... $this->end()` to define a block of template which used in template extention.
 *
 * ## Some Explanation for `$this->ext(...)`
 *
 * Template extension means that you can define a layout as the base template and then other template which extends the base template could use the layout but rewrites the defined blocks to its own content.
 *
 * A layout means that you defines the frame of the page but left with some blocks unfilled. 
 *
 * A sample base template could be define as:
 *
 * ```
 * <!doctype html>
 * <html>
 *   <head>
 *     <title>Sample template site.</title>
 *   </head>
 *   <body>
 *   <?php $this->block('body') ?>
 *   <?php $this->end() ?>
 *   </body>
 * </html>
 * ```
 *
 * The sub template:
 *
 * ```
 * <?php $this->ext('layout.phtml') ?>
 * <?php $this->block('body') ?>
 * <p>This is sub template~</p>
 * <?php $this->end(); ?>
 * ```
 *
 * Then, when extending the base template, sub template could replace the block 'body' with its own content without changing the main layout.
 *
 */

namespace gtf;

/**
 * Gtf Page Template - The abstract class. 
 * A simple template class aims to be fast and flexible.
 *
 * @author yfwz100
 * @version 0.6
 */
abstract class AbstractPage {

    private $page;    # the page block element
    private $tags;    # the tag stack
    private $templ;   # the extends template name
    private $var;     # the user-defined variables

    public function __construct() {
        $this->page = array();
        $this->tags = array();
        $this->var = array();
    }

    /**
     * Define the name with the value.
     * @param $name the name.
     * @param $value the value.
     */
    public function def($name, $value) {
        $this->var[$name] = $value;
    }

    /**
     * Create a block with a specific name.
     * The content of the block is defined by the first time. The other will be replaced by the first definition. Blocks can be nested.
     * @param $name the name of the block.
     */
    protected function block($name) {
        // $this->tags[] = $name;
        array_push($this->tags, $name);
        ob_start();
    }

    /**
     * End the definition of a block.
     */
    protected function end() {
        $name = array_pop($this->tags);
        if (!array_key_exists($name, $this->page)) {
            $this->page[$name] = ob_get_contents();
        }
        // ob_end_flush();
        ob_end_clean();
        echo $this->page[$name];
    }

    /**
     * Extend a template.
     * @param $template the extended template.
     */
    protected function ext($template) {
        $this->templ = $template;
    }

    /**
     * Output the template with this page object.
     * @param $file the template file path relative to view folder.
     * @param $var the optional parameter which indicates variables used in the sub template.
     */
    public function template($file, array $var = null) {
        if (!isset($var)) {
            $var = $this->var;
        }

        ob_start();
        $this->template_impl($file, $var);
        
        if ($this->templ != null) {
            ob_end_clean();

            $templ = $this->templ;
            $this->templ = null;
            $this->template($templ);
        } else {
            ob_end_flush();
        }
    }

    /**
     * Include a template from the other view.
     * Note that the variables will be shared or you can specify the $var.
     * @param $template the template name.
     * @param $var the optional parameter which indicates variables used in the sub template.
     */
    protected function inc($template, array $var = null) {
        if (!isset($var)) {
            $var = $this->var;
        }

        $page = new Page;
        $page->var = $var;
        $page->page = $this->page;
        $page->template(dirname(dirname(dirname(__FILE__))).'/view/'.$template);
    }

    /**
     * The function used to find and render the template.
     * @param $file the file to be used as template.
     * @param $var the variables used in the template.
     */
    protected abstract function template_impl($file, array $var);
}

/**
 * The complete implement of the Gtf Page.
 */
class Page extends AbstractPage {

    protected function template_impl($file, array $var) {
        foreach($var as $key => $value) {
            $$key = $value;
        }
        include $file;
    }

}

