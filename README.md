To Install WISPBill do the following:

Have a Web Server with the PHP extensions mcrypt and SSH2

The Web Server must support and have SSL enabled

Must have MYSQL Database use the schema file to set up

Copy samplebillconfig.php and name it billconfig.php

Adjust billconfig.php to match your needs

Comment out require_once('./session.php'); in createadminuser.php and createadminuser2.php

Go to www.example.com/createadminuser.php and fill it the from

Un Comment out require_once('./session.php'); in createadminuser.php and createadminuser2.php

WISPBill Should be good to go


If  you find bugs report them if you add a feature or fix a bug make a pull request


I Few known limitations

Geocoder is based off of US Census Data therefore it will only geocode US address

QOS and Subscription Management is not done 

WISPBill a PHP based ISP billing platform
    Copyright (C) 2015  Turtles2

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published
    by the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

	@turtles2 on ubiquiti community, DSLReports and Netonix 