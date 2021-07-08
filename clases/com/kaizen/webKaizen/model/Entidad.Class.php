<?php



	class Entidad {

		private $cd_entidad;

		private $ds_entidad;

        private $bl_activo;

        /**
         * @return int
         */
        public function getBl_activo()
        {
            return $this->bl_activo;
        }

        /**
         * @param int $bl_activo
         */
        public function setBl_activo($bl_activo)
        {
            $this->bl_activo = $bl_activo;
        }



		//M�todo constructor




		function Entidad() {



			$this->cd_entidad = 0;

			$this->ds_entidad = '';

            $this->bl_activo = 1;

		}



		//M�todos Get




		function getCd_entidad() {

			return $this->cd_entidad;

		}



		function getDs_entidad() {

			return $this->ds_entidad;

		}



		//M�todos Set




		function setCd_entidad($value) {

			$this->cd_entidad = $value;

		}



		function setDs_entidad($value) {

			$this->ds_entidad = $value;

		}



	}

