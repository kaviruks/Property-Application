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

		$data = DB::select("SELECT * FROM `data_source_x`");
		$PropertyTypes = DB::select("SELECT * FROM `property_types`");
		$PropertyPurpose = DB::select("SELECT * FROM `property_purposes`");
		$Aminities = DB::select("SELECT * FROM `aminities`");
		$cities = DB::select("SELECT * FROM `cities`");

		$orderid = 256781;



		foreach ($data as $d) {

			//Select User data from data source and insert them in to user table

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



			$t = new Propertie();
			$t->user_id = $UserId;
			foreach ($PropertyTypes as $p) {

				if ($d->category == $p->type) {
					$t->property_type_id = $p->id;
				}

			}
			foreach ($cities as $c) {

				if (strpos($d->address, $c->name) !== false) {
					$t->city_id = $c->id;
				}

			}
			
			$t->listing_package_id = '3';
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





			$facilities = trim($d->facilities);
			$facilities = explode(",", $facilities);

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

		

		// echo "<script>console.log('User data saved successfully.');</script>";


		return response()->json(['Data has been imported successfully!']);

		


	}

}