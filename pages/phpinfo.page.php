<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/

	require_once(LINK_LIB.'geoip/geoipcity.inc');
	require_once(LINK_LIB.'geoip/geoipregionvars.php');
	$gi = geoip_open(LINK_DATABASE.'geoip/GeoLiteCity.dat',GEOIP_STANDARD);
	
	$record = geoip_record_by_addr($gi,$_SERVER['REMOTE_ADDR']);
	if(!empty($record)){
		echo $record->country_name . "\n";
		echo $GEOIP_REGION_NAME[$record->country_code][$record->region] . "\n";
		echo $record->city . "\n";
		echo $record->postal_code . "\n";
		echo $record->latitude . "\n";
		echo $record->longitude . "\n";
	}

	geoip_close($gi);
?>
