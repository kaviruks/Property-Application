<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Propertie;
use App\Models\PropertyAminitie;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterController extends Controller
{

	public function create(Request $request)
	{

		// Select all records from data source "data_source_x"
		$data = DB::select("SELECT * FROM `data_source_x`");
		// Select all records from table "property_types"
		$PropertyTypes = DB::select("SELECT * FROM `property_types`");
		// Select all records from table "property_purposes"
		$PropertyPurpose = DB::select("SELECT * FROM `property_purposes`");
		// Select all records from table "aminities"
		$Aminities = DB::select("SELECT * FROM `aminities`");
		// Select all records from table "cities"
		$cities = DB::select("SELECT * FROM `cities`");
	
		// Initialize order id
		$orderid = 256781;


		// Loop through each record in $data
		foreach ($data as $d) {

			 // Create a new user record

			$t = new User();
			$t->name = trim($d->name);
			$t->slug = trim($d->name);
			$t->organisation = $d->organisation;
			$name = trim($d->name);
			$name_array = explode(' ', $name);
			$t->email = $name_array[0] . Str::random(4) . '@gmail.com';
			$t->phone = $d->tell;
			$t->password = Str::random(10);
			$t->address = $d->address;
			$t->save();
			$UserId = $t->id;


			// Create a new order record
			$t = new Order();
			$t->order_id = '#' . ++$orderid;
			$t->user_id = $UserId;
			$t->package_id = '3';
			$current_time = Carbon::parse($d->current_time);
			$t->purchase_date = $current_time->toDateString();
			$t->expired_day = '365';
			$price = $d->price;
			$price = trim($price);
			$price = str_replace(',', '', $price);
			$price = intval($price);
			$t->amount_usd = $price;
			$t->amount_real_currency = $price;
			$t->currency_type = 'SGD';
			$t->currency_icon = 'SGD';
			$t->save();


			// Create a new property record
			$t = new Propertie();
			$t->user_id = $UserId;

			// Get the property type id from $PropertyTypes
			foreach ($PropertyTypes as $p) {

				if ($d->category == $p->type) {
					$t->property_type_id = $p->id;
				}

			}

			 // Get the city id from $cities
			foreach ($cities as $c) {

				if (strpos($d->address, $c->name) !== false) {
					$t->city_id = $c->id;
				}

			}
			
			$t->listing_package_id = '3';

			// Looping through the $PropertyPurpose array to get the property purpose id
			foreach ($PropertyPurpose as $pp) {

				if (strpos($d->details, $pp->purpose) !== false) {
					$t->property_purpose_id = $pp->id;
				}

			}

			$t->title = $d->Page_title;
			$t->slug = $d->Page_title;
			$t->description = $d->description;
			$t->number_of_bedroom = $d->bed;
			$t->number_of_bathroom = $d->bath;
			$area = str_replace(',', '', $d->sqft);
			$area = floatval($area);
			$t->area = $area;
			$t->save();
			$PropertyId = $t->id;




			// Splitting the facilities string into an array using the "," as a separator
			$facilities = trim($d->facilities);
			$facilities = explode(",", $facilities);

			// Looping through the facilities array
			for ($i = 0; $i < count($facilities); $i++) {

				$t = new PropertyAminitie();
				$t->property_id = $PropertyId;

				foreach ($Aminities as $am) {

					if ($facilities[$i] == $am->aminity) {

						$t->aminity_id = $am->id;

					}

				}

				$t->save();




			}






		}

	


		return response()->json(['Data has been imported successfully!']);

		


	}

}