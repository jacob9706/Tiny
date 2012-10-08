<?php
/**
 * Jacob's Form Class to make the creation and rendering of forms easy.
 */
class Forms
{
    private
        $formName,
        $redirectLocation,
        $elements;

    /**
     * @param string $_formName
     * @param string $_redirectLocation
     *   Used as action in <form> tag
     */
    public function setup($_formName = "", $_redirectLocation = "")
    {
        $this->formName = $_formName;
        $this->redirectLocation = $_redirectLocation;
    }

    /**
     * @param FormElement $formElement
     */
    public function addElement(FormElement $formElement)
    {
        $this->elements[] = $formElement;
    }

    public function add($class_name, $args)
    {
        $this->elements[] = new $class_name($args);
    }

    public function render($id = "", $class = "", $beforeEachElement = "", $afterEachElement = "")
    {
        if (!empty($this->redirectLocation)) {
            if (!strpos($this->redirectLocation, "://")) {
                $this->redirectLocation = 'http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/' . $this->redirectLocation;
            }
        }
        $html = "<form method='post' action='{$this->redirectLocation}' id='{$id}' class='{$class}'>";
        foreach ($this->elements as $element) {
            $html .= $beforeEachElement;
            $html .= $element->generateHTML();
            $html .= $afterEachElement;
        }
        $html .= "</form>";
        echo $html;
    }

    public function new_element($class_name, $args)
    {
        return new $class_name($args);
    }
}

/**
 * Default Form Element
 */
class FormElement
{
    public
        $name,
        $id,
        $class,
        $label;

    public function __construct($args)
    {
        $this->name = $args[0];
        $this->id = $args[1];
        $this->class = $args[2];
        $this->label = $args[3];
    }
}

/**
 * Standard Text Input
 */
class TextElement extends FormElement
{
    public function __construct($args)
    {
        parent::__construct($args);
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<input type='text' name='{$this->name}' id='{$this->id}' class='{$this->class}'";
        $html .= !empty($_POST[$this->name]) ? " value='{$_POST[$this->name]}'" : "";
        $html .= ">";

        return $html;
    }
}

/**
 * Password Text Input
 */
class PasswordElement extends FormElement
{
    public function __construct($args)
    {
        parent::__construct($args);
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<input type='password' name='{$this->name}' id='{$this->id}' class='{$this->class}'>";

        return $html;
    }
}

/**
 * Single Checkbox to be passed in array to @CheckboxElement
 */
class Checkbox
{
    public
        $label,
        $value,
        $id;


    public function __construct($args)
    {
        $this->label = $args[0];
        $this->value = $args[1];
        $this->id = $args[2];
    }
}

/**
 * Checkbox Inputs Used With an array of @Checkbox
 */
class CheckboxElement extends FormElement
{
    private
        $elements,
        $before,
        $after;

    public function __construct($args)
    {
        parent::__construct($args[1], "", $args[2], "");

        $this->elements = $args[0];
        $this->before = $args[3];
        $this->after = $args[4];
    }

    public function generateHTML()
    {
        $html = "";
        foreach ($this->elements as $element) {
            $html .= $this->before;
            $html .= "<label for='{$element->id}'>{$element->label}</label>";
            $html .= "<input type='checkbox' name='{$this->name}[]' value='{$element->value}' id='{$element->id}' class='{$this->class}'";
            $html .= !empty($_POST[$this->name]) ? in_array($element->value, $_POST[$this->name]) ? " checked='checked'" : "" : "";
            $html .= ">";
            $html .= $this->after;
        }
        return $html;
    }
}

/**
 * Single Radio to be passed in array to a @RadioElement
 */
class Radio
{
    public
        $label,
        $value,
        $id;

    public function __construct($args)
    {
        $this->label = $args[0];
        $this->value = $args[1];
        $this->id = $args[2];
    }
}

/**
 * Radio inputs to be used with an array of @Radio
 */
class RadioElement extends FormElement
{
    private
        $elements,
        $before,
        $after;

    public function __construct($args)
    {
        parent::__construct($args[1], "", $args[2], "");

        $this->elements = $args[0];
        $this->before = $args[3];
        $this->after = $args[4];
    }

    public function generateHTML()
    {
        $html = "";
        foreach ($this->elements as $element) {
            $html .= $this->before;
            $html .= "<label for='{$element->id}'>{$element->label}</label>";
            $html .= "<input type='radio' name='{$this->name}' value='{$element->value}' id='{$element->id}' class='{$this->class}'";
            $html .= !empty($_POST[$this->name]) ? $_POST[$this->name] == $element->value ? " checked='checked'" : "" : "";
            $html .= ">";
            $html .= $this->after;
        }
        return $html;
    }
}

/**
 * Single Select to be passed in array to a @SelectElement
 */
class Select
{
    public
        $label,
        $value;

    public function __construct($args)
    {
        $this->label = $args[0];
        $this->value = $args[1];
    }
}

/**
 * Select input to be used with an array of @Select
 */
class SelectElement extends FormElement
{
    private
        $elements;

    public function __construct($args)
    {
        parent::__construct($args[1], $args[2], $args[3], $args[4]);
        $this->elements = $args[0];
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<select id='{$this->id}' name='{$this->name}'>";
        foreach ($this->elements as $element) {
            $html .= " <option class='{$this->class}' value='{$element->value}'";
            $html .= (!empty($_POST[$this->name]) && $_POST[$this->name] == $element->value) ? " selected='selected'" : "";
            $html .= ">{$element->label}</option >";
        }
        $html .= "</select>";
        return $html;
    }
}

/**
 * Standard Submit button
 */
class SubmitElement extends FormElement
{
    public function __construct($args)
    {
        parent::__construct($args);
    }

    public function generateHTML()
    {
        $html = " <input type='submit' name='{$this->name}' id='{$this->id}' class='{$this->class}' value ='{$this->label}' >";

        return $html;
    }
}

/**
 * HTML Form Element to be rendered
 */
class HtmlElement extends FormElement
{
    private
        $htmlString;

    public function __construct($_htmlString)
    {
        $this->htmlString = $_htmlString;
    }

    public function generateHTML()
    {
        return $this->htmlString;
    }
}