<?php

namespace Parallalax\PostcodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{

    public function getCityFromPostcodeAction($postcode) {

        $em = $this->getDoctrine()->getManager('parallalax_postcode');

		$postcode = $em->getRepository(\Parallalax\PostcodeBundle\Entity\Postcode::class, 'parallalax_postcode')->findOneByNum($postcode);

		$citiesArray = array();

		$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

		foreach($postcode->getCities() as $city) {

			$citiesArray[] = array('name' => strtoupper(strtr($city->getName(), $unwanted_array)));
		}

		//$arrayToReturn = array('object' => array('city' => $citiesArray));

		$response = new JsonResponse();
		$response->setData($citiesArray);
		return $response;
	}


	public function getCityFromSearchAction($search, $postcode) {

		$em = $this->getDoctrine()->getManager('parallalax_postcode');


		if($postcode == 0) {

			$allCities = $em->createQueryBuilder()
					->select('c')
					->from('ParallalaxPostcodeBundle:City', 'c')
					->where('c.name like \''. $search .'%\'')
					->groupBy('c.name')
					->getQuery()
					->getResult();
		}
		else {

			$postcode = $em->getRepository(\Parallalax\PostcodeBundle\Entity\Postcode::class)->findOneByNum($postcode);

			$allCities = new \Doctrine\Common\Collections\ArrayCollection();

			if(!empty($postcode)) {

				//convert cities object to arrayCollection
				foreach($postcode->getCities() as $city) $allCities->add($city);

				if($search != 0) {

					$criteria = Criteria::create()->where(Criteria::expr()->like_('name', $search));

					//convert cities object to arrayCollection
					$allCities = $allCities->matching($criteria);//filter data with search
				}
			}
		}



		$citiesArray = array();

		foreach($allCities as $city) {

			$citiesArray[] = array('name' => strtoupper($city->getName()));
		}

		//$arrayToReturn = array('object' => array('city' => $citiesArray));

		$response = new JsonResponse();
		$response->setData($citiesArray);
		return $response;
	}

	public function getPostcodeFromSearchAction($search) {

		$em = $this->getDoctrine()->getManager('parallalax_postcode');

		$searchedCity = $em->createQueryBuilder()
					->select('c')
					->from('ParallalaxPostcodeBundle:City', 'c')
					->where('c.name like \''. $search .'%\'')
					->groupBy('c.name')
					->getQuery()
					->getResult();

		$postcodeArray = array();
        if($searchedCity !== null) {
            foreach($searchedCity as $s) {
        		foreach($s->getPostcodes() as $postcode) {

        			$postcodeArray[] = array('name' => $postcode->getNum());
    		    }
            }
        }

		$response = new JsonResponse();
		$response->setData($postcodeArray);
		return $response;
	}
}
