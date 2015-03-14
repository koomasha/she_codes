<?php 	
	class branches{
		public function get_branches()
		{
			global $branch_dal;
			return array("branches" => $branch_dal->get_branches());			
		}
	}
?>