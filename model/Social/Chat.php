<?php

    class Chat extends User{

        public function __construct(array $construct=NULL){
            foreach($construct as $key=>$value) $this->$key = $value;
        }

    }
