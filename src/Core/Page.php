<?php

namespace Aden\aFramework\Core;

class Page {
    protected $html, $depends;

    public $Name, $Description;

    public function __construct(string $name, string $description, array $depends=[], $html=null) {
        $this->Name = $name;
        $this->Description = $description;

        if($html)
            $this->html = $html;
        
        if(count($depends) > 0)
            $this->depends = $depends;
    }

    public function Render() : void {
        echo $this->html;
    }

    public function RenderDependancy() : void {
        if($this->depends == null)
            return;

        foreach($this->depends as $val) {
            $ext = FileService::GetExtension($val);

           if($ext == "js") {
                echo "<script src='assets/$val'></script>";
           } else if($ext == "css") {
                echo "<link rel='stylesheet' href='assets/$val'>";
           }
        }
    }

    public function SetName($name) : void {
        $this->Name = $name;
    }
    public function SetDescription($desc) : void {
        $this->Description = $desc;
    }
}