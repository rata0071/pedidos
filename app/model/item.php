<?php

class model_item {
}

class item extends Model {

		private $producto = null;

        public function getProducto() {
                if ( ! $this->producto ) { 
                        $this->producto = Model::factory('producto')->find_one($this->producto_id);
                }
                return $this->producto;
        }
	
}
