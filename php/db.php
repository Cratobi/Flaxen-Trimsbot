<?php
class db{
	public $db;

	function __construct(){
		$this->db_connect('localhost','root','','trimsbot_db');
	}

	function db_connect($host,$user,$pass,$database){
		$this->db = new mysqli($host, $user, $pass, $database);

		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
	}

	function check_changes_orders(){
		$result = $this->db->query('SELECT count_orders FROM counts WHERE id=1');
		if($result = $result->fetch_object()){
			return $result->count_orders;
		}
		return 0;
	}
	function check_username($username){
		$username = $this->db->real_escape_string($username);
		if($result = $this->db->query('SELECT username FROM accounts WHERE username = "'.$username.'"')){
			while($r = $result->fetch_object()){
				return true;
			}
		}
		else{
			return false;
		}
	}
	function check_password($password){
		$password = $this->db->real_escape_string($password);
		if($result = $this->db->query('SELECT password FROM accounts WHERE password = "'.$password.'"')){
			while($r = $result->fetch_object()){
				return true;
			}
		}
		else{
			return false;
		}
	}
	function fetch_privillege($username){
		$username = $this->db->real_escape_string($username);
		if($result = $this->db->query('SELECT privillege FROM accounts WHERE username = "'.$username.'"')){
			while($r = $result->fetch_object()){
				return $r->privillege;
			}
		}
	}
	function fetch_name($username){
		$username = $this->db->real_escape_string($username);
		if($result = $this->db->query('SELECT name FROM accounts WHERE username = "'.$username.'"')){
			while($r = $result->fetch_object()){
				return $r->name;
			}
		}
	}
	function check_changes_items(){
		$result = $this->db->query('SELECT count_items FROM counts WHERE id=1');
		if($result = $result->fetch_object()){
			return $result->count_items;
		}
		return 0;
	}
	function register_changes_orders(){
		$this->db->query('UPDATE counts SET count_orders = NOW(6) WHERE id=1');
	}
	function register_changes_items(){
		$this->db->query('UPDATE counts SET count_items = NOW(6) WHERE id=1');
	}
	// Date format
	function date_convert($data){
		$date = $data;
		if (empty($date)) {
			return $date;
		} elseif ($date == "1970-01-01") {
			return NULL;
		}
		else{
			return date("d-m-Y", strtotime($date));
		}
	}
	// Fetch items
	function fetch_items($order_id){
		if($result = $this->db->query('SELECT * FROM items WHERE order_id='.$order_id.' ORDER BY sl_no')){
			$return = '';
			while($r = $result->fetch_object()){
				if($r->sl_no == 32 || $r->sl_no == 33){
					$edit_control = ' class="td-editable td-txt" data-name="item" data-pk="'.$r->id.'"';
				} else {
					$edit_control = "";
				}
				$return .= '<tr>	
							<td'.$edit_control.'>'.htmlspecialchars($r->item).'</td>
							<td class="td-editable td-txt" data-name="description" data-pk="'.$r->id.'">'.htmlspecialchars($r->description).'</td>
							<td class="td-editable td-no" data-name="price" data-pk="'.$r->id.'">'.$r->price.'</td>
							<td class="td-editable td-date" data-name="booking_date" data-pk="'.$r->id.'">'.$this->date_convert($r->booking_date).'</td>
							<td class="td-editable td-no" data-name="booking_quantity" data-pk="'.$r->id.'">'.$r->booking_quantity.'</td>
							<td class="td-editable td-date" data-name="delivery_date" data-pk="'.$r->id.'">'.$this->date_convert($r->delivery_date).'</td>
							<td class="td-editable td-no" data-name="delivery_quantity" data-pk="'.$r->id.'">'.$r->delivery_quantity.'</td>
							<td class="td-editable td-no" data-name="delivery_chalan_no" data-pk="'.$r->id.'">'.$r->delivery_chalan_no.'</td>
							<td class="td-editable td-no" data-name="bill_no" data-pk="'.$r->id.'">'.$r->bill_no.'</td>
							<td class="td-editable td-date" data-name="bill_date" data-pk="'.$r->id.'">'.$this->date_convert($r->bill_date).'</td>
							<tr/>';
			}
			return $return;
		}
	}
	// Fetch orders
	function fetch_orders(){
		if($result = $this->db->query('SELECT counts.count_orders, buyers.*, orders.* FROM orders JOIN buyers JOIN counts WHERE orders.buyer_id = buyers.id ORDER BY orders.indicator, orders.id DESC, orders.shipment_date, buyers.buyer_name, orders.order_no')){
			$return = '';
			while($r = $result->fetch_object()){
				if($r->indicator == 1){
					$indicator = " checked";
				} else {
					$indicator = "";
				}
				$return .= '<tr class="clickable-row'.$indicator.'" 	data-id="'.$r->id.'">';
				$return .= '<td class="td-txt">'.htmlspecialchars($r->buyer_name).'</td>
							<td class="td-date">'.htmlspecialchars($r->order_no).'</td>
							<td class="td-no">'.htmlspecialchars($r->style_no).'</td>
							<td class="td-date">'.$r->quantity.'</td>
							<td class="td-no">'.$this->date_convert($r->shipment_date).'</td>
							<td class="td-no">'.htmlspecialchars($r->status).'</td>
							<td class="td-date">'.htmlspecialchars($r->remarks).'</td>'.$this->menu($r->id);
				$return .= '<tr/>';
			}
			return $return;
		}
	}
	function menu($idx){
		if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
			return '<td><i class="material-icons icon-more">more_vert</i></td>';
		} else {
			return '';
		}
	}
	function fetch_order_no($orders_id){
		if($result = $this->db->query('SELECT orders.order_no FROM orders WHERE id =  '.$orders_id.'')){
			while($r = $result->fetch_object()){
				return htmlspecialchars($r->order_no);
			}
		}
	}
	function fetch_order_info($orders_id){
		if($result = $this->db->query('SELECT buyers.*, orders.* FROM orders JOIN buyers WHERE orders.id = '.$orders_id.' AND orders.buyer_id = buyers.id')){
			while($r = $result->fetch_object()){
				$indicator = "";
				if($r->indicator == 1){
					$indicator = " (Completed)";
				}
				return '<span>Order number: '.htmlspecialchars($r->order_no).''.$indicator.'</span><span style="float: right">'.htmlspecialchars($r->buyer_name).' | '.$this->date_convert($r->shipment_date).'('.$r->quantity.'pcs)';
			}
		}
	}
	// Fetch check
	function fetch_check($order_id){
		if($result = $this->db->query('SELECT indicator FROM orders WHERE id='.$order_id.'')){
			while($r = $result->fetch_object()){
				return $r->indicator;
			}
		}
	}
	function fetch_buyers($idx){
		if($result = $this->db->query('SELECT * FROM buyers')){
			$return = '';
			while($r = $result->fetch_object()){
				$selection = "";
				if($r->id == $idx){
						$selection = " selected";
				}
				$return .= '<option value="'.$r->id.'"'.$selection.'>'.$r->buyer_name.'</option>';
			}
			return $return;
		}
	}
	// Fetch specific orders
	function fetch_specific_order($idx){
		if($result = $this->db->query('SELECT buyers.*, orders.* FROM  orders JOIN buyers WHERE orders.buyer_id = buyers.id AND orders.id = '.$idx.'')){
			$return = '';
			while($r = $result->fetch_object()){
				$return .= '<input type="hidden" class="form-control" name="idx" value="'.$r->id.'">
					<div class="form-group">
							<label>Buyer</label>
							<select id="selectBuyer" name="buyer_name" class="form-control">
								'.$this->fetch_buyers($r->buyer_id).'
							</select>
					</div>
					<div class="form-group">
						<label>Order Number</label>
						<input type="text" class="form-control" name="order_no" value="'.htmlspecialchars($r->order_no).'" autocomplete="off">
					</div>
					<div class="form-group">
						<label>Style Number</label>
						<input type="text" class="form-control" name="style_no" value="'.htmlspecialchars($r->style_no).'" autocomplete="off">
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<label>Quantity (Pcs)</label>
							<input type="text" class="form-control" name="quantity" value="'.$r->quantity.'" placeholder="0" autocomplete="off">
							<small class="form-text text-muted">Only Numbers</small>
						</div>
						<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<label>Shipment Date</label>
							<input type="text" class="form-control datepicker" name="shipment_date" value="'.$this->date_convert($r->shipment_date).'" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<input type="text" class="form-control" name="status" value="'.htmlspecialchars($r->status).'" autocomplete="off">
					</div>
					<div class="form-group">
						<label>Remarks</label>
						<input type="text" class="form-control" name="remarks" value="'.htmlspecialchars($r->remarks).'" autocomplete="off">
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<a class="btn btn-lg btn-grey" data-dismiss="modal">Cancel</a>
					<input type="submit" class="btn btn-lg btn-dark" value="Confirm">
				';
			}
			return $return;
		}
		return FALSE;
	}
	// Edit order
	function edit_order($idx, $style_no, $order_no, $quantity, $shipment_date, $status, $remarks){
		$style_no = $this->db->real_escape_string($style_no);
		$order_no = $this->db->real_escape_string($order_no);
		$shipment_date = date('Y-m-d', strtotime($shipment_date));
		$status = $this->db->real_escape_string($status);
		$remarks = $this->db->real_escape_string($remarks);
		if($this->db->query('UPDATE orders SET style_no = "'.$style_no.'", order_no = "'.$order_no.'", quantity = "'.$quantity.'", shipment_date = "'.$shipment_date.'", status = "'.$status.'" WHERE id = "'.$idx.'";')){
			$this->register_changes_orders();
			return TRUE;
		}
		return FALSE;
	}


	// Add orders
	function add_order($buyer_id, $style_no, $order_no, $quantity, $shipment_date, $status, $remarks){
		$buyers_id = $this->db->real_escape_string($buyer_id);
		$style_no = $this->db->real_escape_string($style_no);
		$order_no = $this->db->real_escape_string($order_no);
		$quantity = $this->db->real_escape_string($quantity);
		$shipment_date = date('Y-m-d', strtotime($shipment_date));
		$status = $this->db->real_escape_string($status);
		$remarks = $this->db->real_escape_string($remarks);
		if($this->db->query('INSERT INTO orders (buyer_id, style_no, order_no, quantity, shipment_date, status, remarks) VALUES ("'.$buyer_id.'", "'.$style_no.'", "'.$order_no.'", "'.$quantity.'", "'.$shipment_date.'", "'.$status.'", "'.$remarks.'")')){
			$insert_id = $this->db->insert_id;
			$this->add_items($insert_id);
		}		
		return FALSE;
	}
	// Add buyer
	function add_buyer($buyer_name){
		$buyers_name = $this->db->real_escape_string($buyer_name);
		if($this->db->query('INSERT INTO buyers (buyer_name) VALUES ("'.$buyer_name.'")')){
			return TRUE;
		}
		return FALSE;
	}
	// Add user
	function add_user($name, $username, $password, $privillege){
		$name = $this->db->real_escape_string($name);
		$username = $this->db->real_escape_string($username);
		$password = $this->db->real_escape_string($password);
		if($this->db->query('INSERT INTO accounts (username, name, password, privillege) VALUES ("'.$username.'", "'.$name.'",  "'.$password.'",  "'.$privillege.'")')){
		}
		return FALSE;
	}
	// Add items
	function add_items($order_id){
		if($this->db->query('INSERT INTO items(order_id, sl_no, item) VALUES ('.$order_id.', 1, "Main Label"), ('.$order_id.', 2, "Size Label"), ('.$order_id.', 3, "Care Label"), ('.$order_id.', 4, "ID Label"), ('.$order_id.', 5, "Other Label"), ('.$order_id.', 6, "Hang Tag"), ('.$order_id.', 7, "Price Tag"), ('.$order_id.', 8, "Special Tag"), ('.$order_id.', 9, "Hang Tag Sticker"), ('.$order_id.', 10, "Poly Sticker"), ('.$order_id.', 11, "Carton Sticker"), ('.$order_id.', 12, "Poly Bag"), ('.$order_id.', 13, "Blister Poly"), ('.$order_id.', 14, "Plastic Button"), ('.$order_id.', 15, "Metal Button"), ('.$order_id.', 16, "Snap Button"), ('.$order_id.', 17, "Twill Tape - 1"), ('.$order_id.', 18, "Twill Tape - 2"), ('.$order_id.', 19, "Drawsting"), ('.$order_id.', 20, "Sewing Thread - 1"), ('.$order_id.', 21, "Sewing Thread - 2"), ('.$order_id.', 22, "Sewing Thread - 3"), ('.$order_id.', 23, "Sewing Thread - 4"), ('.$order_id.', 24, "Elastic - 1"), ('.$order_id.', 25, "Elastic - 2"), ('.$order_id.', 26, "Elastic - 3"), ('.$order_id.', 27, "Back Board"), ('.$order_id.', 28, "Photo Board"), ('.$order_id.', 29, "Tissue"), ('.$order_id.', 30, "Gum Tape"), ('.$order_id.', 31, "Carton"), ('.$order_id.', 32, "Other"), ('.$order_id.', 33, "Other");')){
			$this->register_changes_orders();
			return TRUE;
		}
		return FALSE;
	}
	// Fetch buyer name
	function fetch_buyer_name(){
		if($result = $this->db->query('SELECT * FROM buyers')){
			$return = '';
			while($r = $result->fetch_object()){
				$return .= '<option value="'.$r->id.'">'.htmlspecialchars($r->buyer_name).'</option>';
			}
			return $return;
		}
	}
	function fetch_buyer_name_sort(){
		if($result = $this->db->query('SELECT * FROM buyers')){
			$return = '';
			while($r = $result->fetch_object()){
				$return .= '<option value="'.htmlspecialchars($r->buyer_name).'">'.htmlspecialchars($r->buyer_name).'</option>';
			}
			return $return;
		}
	}
	// Remove order
	function remove_order($idx){
		$idx = $this->db->real_escape_string($idx);
		if($this->db->query('DELETE FROM orders WHERE id = '.$idx.'')){
			if($this->db->query('DELETE FROM items WHERE order_id = '.$idx.'')){
			$this->register_changes_orders();
			return TRUE;
			}
		}
		return FALSE;
	}
	// Checkout order
	function checkout_order($idx){
		$idx = $this->db->real_escape_string($idx);
		if($this->db->query('UPDATE orders, items SET orders.indicator = IF(orders.indicator=0, 1, 0), items.indicator = IF(items.indicator=0, 1, 0) WHERE orders.id ='.$idx.' AND items.order_id='.$idx.'')){
			$this->register_changes_orders();
			return TRUE;
		}
		return FALSE;
	}
	// Check items existence
	function existence_item($order_id){
		$order_id = $this->db->real_escape_string($order_id);
		$result = $this->db->query('SELECT id FROM orders WHERE id='.$order_id.'');
		if($result = $result->fetch_object()){
			return TRUE;
		}
		return FALSE;
	}
	// Edit items
	function edit_items($id, $header, $value){
		$header = $this->db->real_escape_string($header);
		$value = $this->db->real_escape_string($value);
		if($header == "booking_date" || $header == "delivery_date" || $header == "bill_date"){
			$value = date('Y-m-d', strtotime($value));
		}
		if($this->db->query('UPDATE items SET '.$header.' = "'.$value.'" WHERE id = '.$id.'')){
			$this->register_changes_items();
			return TRUE;
		}
		header('HTTP/1.0 400 Bad Request', true, 400);
		echo "This field is required!";
	}
	function check_ref_permission(){
		if($result = $this->db->query('SELECT * FROM ref WHERE id = 1')){
			while($r = $result->fetch_object()){
				return $r->permission;
			}
		}
	}
	function fetch_ref_code(){
		if($result = $this->db->query('SELECT * FROM ref WHERE id = 1')){
			while($r = $result->fetch_object()){
				return $r->code;
			}
		}
	}
	function set_ref($permission){
		$random = str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_BOTH);
		if($permission == 0){
			$random = 'NULL';
		}
		if($this->db->query('UPDATE ref SET code = '.$random.',  permission = '.$permission.' WHERE id = 1')){
			return TRUE;
		}
		return FALSE;
	}
}
