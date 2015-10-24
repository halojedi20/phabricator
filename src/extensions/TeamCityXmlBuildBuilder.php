<?php

final class TeamCityXmlBuildBuilder {

    private $xml;

    function __construct(){
        $this->xml = new DOMDocument('1.0', 'UTF-8');
        $buildRoot = $this->xml->createElement('build');
        $this->xml->appendChild($buildRoot);
    }

    function addBuildId($buildId){
        $buildIdElement =
            $this->
            xml->
            createElement('buildType');

        $buildIdElement->setAttribute('id', $buildId);

        $this->xml->appendChild($buildIdElement);

        return $this;
    }

    function addBranchName($branchName){
        $this->
            xml->
            getElementsByTagName('build')->
            item(0)->
            setAttribute('branchName', $branchName);

        return $this;
    }

    function addHarbormasterPHID($phid){
        $this->addProperty('env.harbormasterTargetPHID', $phid);
        return $this;
    }

    function addDiffId($diffId){
        $this->addProperty('env.diffId', $diffId);
        return $this;

    }

    function build(){
        return $this->xml->saveXML();
    }

    private function addProperty($name, $value){
        $this->verifyPropertiesExist();

        $property = $this->xml->createElement('property');
        $property->setAttribute('name', $name);
        $property->setAttribute('value', $value);

        $this->
            xml->
            getElementsByTagName('properties')->
            item(0)->
            appendChild($property);
    }

    private function verifyPropertiesExist(){
        if($this->xml->getElementsByTagName('properties')->length == 0){
            $propertiesElement = $this->xml->createElement('properties');
            $this->xml->appendChild($propertiesElement);
        }
    }



}