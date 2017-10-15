<?php

class SitesExtend extends Sites{


    public function registroSitesOperacion(){
        if(count($this->sitesOperacions) == 0)
            return false;
        return true;
    }
    public function registroSitesMantenimientos(){
        if(count($this->sitesMantenimientoses) == 0)
            return false;
        return true;
    }
    public function registroSitesConsumos(){
        if(count($this->sitesConsumoses) == 0)
            return false;
        return true;
    }
    public function registroSitesEstadosIniciales(){
        if(count($this->sitesEstadosIniciales) == 0)
            return false;
        return true;
    }
    public function registroSitesCensosCarga(){
        if(count($this->sitesCensosCargas) == 0)
            return false;
        return true;
    }

    /**
     * @return bool si se ha completado todo el registro
     */
    public function registroCompleto(){
        $completo = true;
        if(!$this->registroSitesOperacion())
            $completo = false;
        if(!$this->registroSitesMantenimientos())
            $completo = false;
        else if(!$this->registroSitesConsumos())
            $completo = false;
        else if(!$this->registroSitesEstadosIniciales())
            $completo = false;
        else if(!$this->registroSitesCensosCarga())
            $completo = false;

        if($completo)
            if($this->completo == 0){
                $this->completo = 1;
                $this->save();
            }

        return $completo;
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sites the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}