<?php
	
	
	class json_injest {
		
		
		/////////////////
		//  VARIABLES  //
		/////////////////
		public $_our_json;
		public $_out_type;
		
		
		public function __construct( $givenJSON) {
			
			/*
				we're given a piece of json with our initialization
				get the type of that code, and pass it to our processing functions
			*/
			
			$givenJSON = json_decode( $givenJSON );  //  decode the json
			$_the_type = gettype( $givenJSON );  //  get the type
			
			//  save it for later
			$this->_our_json = $givenJSON;
			$this->_our_type = $_the_type;
			//echo $_the_type;
			
			switch ( $_the_type ) {
				case "string":
					$this->_is_string( $givenJSON );
					break;
				case "integer":
					$this->_is_integer( $givenJSON );
					break;
				case "array":
					$this->_is_array( $givenJSON );
					break;
				case "object":
					$this->_is_object( $givenJSON );
					break;
			}
			
		}
		
		
		
		/*
			our "is functions"
			run check, and echo with print function
			case statement in constructor does most of the work here
			is statements could be expanded to include "gettype"
		*/
		
		
		public function _is_string ($given) {
			echo $this->_print_string ( $given );
		}
		public function _is_integer ( $given ) {
			echo $this->_print_integer( $given );
		}
		
		public function _is_array ( $given ) {
			echo $this-_print_array( $given );
		}
		
		public function _is_object ( $given ) {
			
			/*
				in json, associative arrays look a lot like objects...
				if any of the values are array, or other objects,
				we have an object.
				else, we have a vanilla assocaitive array
			*/
			
			if ( $this->_array_is_associative ( $given ) === "object" ) {
				//  we have an object
				echo $this->_print_object ( $given );
			} else {
				//  we have an associative array
				echo $this->_print_associative_array ( $given );
			}
			
		}
		
		
		//////////////////////////
		//  UTILITIES FUNCTION  //
		//////////////////////////
		public function _array_is_associative ( $given ) {
			
			/*
				simple checker for an associative array
				we could / should also check to make sure it's array, since it's a public function,
				but I was moving fast...
			*/
				
			foreach ( $given as $key => $item ):
				
				$item_type = gettype( $item );
				
				if ( $item_type !== "string" ) {
					return "object";
					break;
				}
				
			endforeach;
			
			//  if we've made it this far, we have an associative array
			return "associativearray";
			
		}
		
		
		
		
		
		
		
		
		public function _print_string ( $given ) {
			return $given;
		}
		
		public function _print_integer ( $given ) {
			return $given;
		}
		
		public function _print_array ( $given ) {
			$output_string = "<ul>";
			foreach ( $given as $item ):
				$output_string .= "<li>$item</li>";
			endforeach;
			$output_string .= "</ul>";
			return $output_string;
			
		}
		
		public function _print_associative_array ( $given ) {
			
			/*
				print key item pair
			*/
			
			$output_string = "<ul>";
			foreach ( $given  as $key => $item ):
				$output_string .= "<li>";
				$output_string .= "$key => $item";
				$output_string .= "</li>";
			endforeach;
			$output_string .= "</ul>";
			return $output_string;
		}
		
		public function _print_object ( $given ) {
			
			/*
				work through objects...
				if the item is another object, call this function recursively
				output ul with everything we need...
			*/
			
			$output_string = "<ul>";
			foreach ( $given  as $key => $item ):
				$item_type = gettype( $item );
				switch ( $item_type ){
					case "string":
						$output_string .= "<li>";
							$output_string .= "$key => $item";
						$output_string .= "</li>";
						break;
					case "integer":
						$output_string .= "<li>";
							$output_string .= "$key => $item";
						$output_string .= "</li>";
						break;
					case "array":
						$output_string .= "<li>";
							$output_string .= $this->_print_array ( $item );
						$output_string .= "</li>";
						break;
					case "object":
						$output_string .= "<li>";
							$output_string .= $this->_print_object ( $item );
						$output_string .= "</li>";
						break;
				}
				
				
			endforeach;
			$output_string .= "</ul>";
			return $output_string;
		}
		
		
		
		
		
		
	}
	
	
	/*
		data types to play with
	*/
	
	//	string
	//$theContent = "bang";
	
	//	integer
	//$theContent = 5;
	
	//	sequential array
	//$theContent = array( "bang", "test", "done");
	
	//	associative array
	//$theContent = array('fruit1' => 'apple', 'fruit2' => 'orange', "fred" => "banding", 'veg2' => 'carrot');
	
	//	nested array / object
	//$theContent = array('fruit1' => 'apple', 'fruit2' => 'orange', "fred" => array("bang", "test", "bozo"), 'tomato', 'veg2' => 'carrot');
	
	//	actual object
	$theContent->bang = array( "bang", "testing variable", "awesomeness");
	$theContent->zilla = array( "beer", "bikes", "snow");
	
	
	$theContent = json_encode($theContent);
	$_json_injest = new json_injest ($theContent);
?>