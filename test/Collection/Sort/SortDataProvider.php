<?php

namespace Novuso\Test\System\Collection\Sort;

use Novuso\Test\System\Resources\User;

trait SortDataProvider
{
    public function comparableArrayProvider()
    {
        $records = $this->getUserDataUnsorted();

        $data = [];
        foreach ($records as $record) {
            $data[] = new User($record);
        }

        $sorted = $records;
        usort($sorted, function ($a, $b) {
            $comp = strnatcmp($a['username'], $b['username']);
            if ($comp > 0) {
                return 1;
            }
            if ($comp < 0) {
                return -1;
            }

            return 0;
        });

        return [[$data, $sorted]];
    }

    public function stringArrayProvider()
    {
        $strings = $this->getUnsortedStrings();

        $sorted = $strings;
        usort($sorted, function ($a, $b) {
            $comp = strnatcmp($a, $b);
            if ($comp > 0) {
                return 1;
            }
            if ($comp < 0) {
                return -1;
            }

            return 0;
        });

        return [[$strings, $sorted]];
    }

    public function integerArrayProvider()
    {
        $integers = $this->getUnsortedIntegers();

        $sorted = $integers;
        sort($sorted);

        return [[$integers, $sorted]];
    }

    public function floatArrayProvider()
    {
        $floats = $this->getUnsortedFloats();

        $sorted = $floats;
        sort($sorted);

        return [[$floats, $sorted]];
    }

    protected function getUserDataSortedByLastName()
    {
        $data = $this->getUserDataUnsorted();
        usort($data, function ($user1, $user2) {
            return strnatcmp($user1["lastName"], $user2["lastName"]);
        });

        return $data;
    }

    protected function getUnsortedStrings()
    {
        return [
            "NoLg4udYw0", "dOs9BqTix5", "Glxq7z1ivR", "r0ZhSKf2SF", "leuyOXRcwV", "0OrDtFDn4W", "L3AcxUTNHq",
            "F8OSgxyr34", "9lwkwmrApL", "m3qb4R9K6t", "MfAaFC2tBC", "uC9XyP4pfX", "FUImXyImwF", "VeJVESwxGg",
            "B13ekwo5V6", "HnTOkEK226", "31efZkTlBI", "M5JKHqdddh", "KK3e0RXFl4", "tHacd99kQE", "vy2lSWYlQT",
            "ysLLxyviuP", "Det8gqxipz", "Bv4uo95KKD", "uP3XRemp0P", "TGBBd8HISn", "OZNtECBErw", "08rjecCBRd",
            "2GcYVP0zE3", "aaov9f0Vqi", "702rMqOZBm", "S8aPAxoSWz", "r5FdGJA1rc", "gFahFYdYzO", "Y24zWMXZFf",
            "sWfANiFBBL", "Ma4Q372PLp", "9aBYNSCTK0", "YTtHDUyZXv", "Mwwl87T2d8", "4djfMoYCqK", "vd1r2ZNlkq",
            "kKjsebGSeR", "T7czuscIPU", "ozvYW6H8tv", "naAZObh3M5", "DwF5HEHhMC", "FTvoEA6wPd", "NANiO6czSp",
            "hbIdBTsruP", "jS4RByxAFe", "HN8S48pzMs", "fC3Gpdw92t", "AwQObCe5yy", "SiSLCZHcWU", "3Z9GVRh0cg",
            "uyheJ7kXbV", "qTtQSh4sBG", "VMH6TVhgsV", "4R6hldJ5w0", "whKhSunxp4", "UdcM63lRHv", "9Y8viBaqoG",
            "BLrDtToaK8", "MmetOwdNJP", "MAEjzY65gh", "nkxVu416W4", "42hYZqbzNi", "Qr5DctlDtk", "soZ06lbwwa",
            "TYdClzoqIm", "KaW5fwAgjg", "d5zCyLho3H", "8glQWvjfE8", "9zcpPjzHSq", "ZjnD9N68BC", "oV9VoodI1d",
            "NZs8fbF75C", "6x3LFP0K0o", "kqgjiz4R9B", "LDTtGWlALF", "pJNrWaj0Rx", "VehD7r9Ewy", "QYh3zsKMBH",
            "PkRYGiRflo", "LKMkitLygr", "Le9wVkinnV", "DKxh8VCUFd", "KIVwvuHTRH", "im8tAxpHcv", "XmBRjprREZ",
            "lRJWbdtq5y", "Om22Puti7D", "OG1uo0wYEo", "X2MiTB3n5w", "q5sjdRle4C", "twuYN2ZOAp", "FLZxi21BhZ",
            "JmAsBPAztr", "hWiM9KnQvA", "702rMqOZBm"
        ];
    }

    protected function getUnsortedIntegers()
    {
        return [
            942, 510, 256, 486, 985, 152, 385, 836, 907, 499, 519, 194, 832, 42, 246, 409, 886, 555, 561, 209,
            865, 125, 385, 568, 35, 491, 974, 784, 980, 800, 591, 884, 648, 971, 583, 359, 907, 758, 438, 34,
            398, 855, 364, 236, 817, 548, 518, 369, 817, 887, 559, 941, 653, 421, 19, 71, 608, 316, 151, 296,
            831, 807, 744, 513, 668, 373, 255, 49, 29, 674, 911, 700, 486, 14, 323, 388, 164, 786, 702, 273,
            207, 25, 809, 635, 68, 134, 86, 744, 486, 657, 155, 445, 702, 78, 558, 17, 394, 247, 171, 236
        ];
    }

    protected function getUnsortedFloats()
    {
        return [
            0.5070, 0.9410, 0.8974, 0.0974, 0.1896, 0.5031, 0.4925, 0.9585, 0.8963, 0.0432, 0.3615, 0.8139,
            0.0815, 0.3585, 0.6930, 0.9415, 0.6218, 0.0315, 0.8622, 0.9658, 0.7675, 0.8723, 0.2158, 0.7626,
            0.4682, 0.9542, 0.9969, 0.2212, 0.2375, 0.8691, 0.4940, 0.9322, 0.3798, 0.8927, 0.9114, 0.1880,
            0.2344, 0.7198, 0.9561, 0.0207, 0.7018, 0.1498, 0.4089, 0.1657, 0.8239, 0.6273, 0.3496, 0.6833,
            0.5476, 0.8841, 0.6744, 0.8232, 0.5214, 0.7791, 0.3598, 0.5720, 0.6833, 0.1892, 0.3123, 0.1021,
            0.9771, 0.0546, 0.6526, 0.6950, 0.5155, 0.2928, 0.0335, 0.8700, 0.9209, 0.1179, 0.4065, 0.4997,
            0.3633, 0.4993, 0.6956, 0.3939, 0.5678, 0.0623, 0.5582, 0.3882, 0.1263, 0.9748, 0.9149, 0.2050,
            0.7274, 0.0134, 0.6425, 0.9666, 0.9541, 0.0180, 0.3686, 0.6039, 0.8169, 0.4899, 0.3441, 0.7210,
            0.7729, 0.6093, 0.5783, 0.1270
        ];
    }

    protected function getUserDataUnsorted()
    {
        return [
            [
                "lastName"  => "Swaniawski",
                "firstName" => "Alexandria",
                "username"  => "swaniawski.alexandria",
                "email"     => "swaniawski.alexandria@example.com",
                "birthDate" => "1963-02-08 19:45:59"
            ],
            [
                "lastName"  => "Christiansen",
                "firstName" => "Vernice",
                "username"  => "christiansen.vernice",
                "email"     => "christiansen.vernice@example.com",
                "birthDate" => "1984-10-18 00:30:16"
            ],
            [
                "lastName"  => "Stanton",
                "firstName" => "Lilyan",
                "username"  => "stanton.lilyan",
                "email"     => "stanton.lilyan@example.net",
                "birthDate" => "1982-08-13 18:21:53"
            ],
            [
                "lastName"  => "Hermiston",
                "firstName" => "Michele",
                "username"  => "hermiston.michele",
                "email"     => "hermiston.michele@example.org",
                "birthDate" => "1961-04-06 14:35:45"
            ],
            [
                "lastName"  => "Botsford",
                "firstName" => "Anya",
                "username"  => "botsford.anya",
                "email"     => "botsford.anya@example.net",
                "birthDate" => "1957-11-29 15:17:17"
            ],
            [
                "lastName"  => "Gerlach",
                "firstName" => "Martin",
                "username"  => "gerlach.martin",
                "email"     => "gerlach.martin@example.net",
                "birthDate" => "1967-09-25 06:05:09"
            ],
            [
                "lastName"  => "Quigley",
                "firstName" => "Jarred",
                "username"  => "quigley.jarred",
                "email"     => "quigley.jarred@example.net",
                "birthDate" => "1994-02-25 01:54:42"
            ],
            [
                "lastName"  => "Effertz",
                "firstName" => "Christine",
                "username"  => "effertz.christine",
                "email"     => "effertz.christine@example.com",
                "birthDate" => "1971-07-26 07:30:44"
            ],
            [
                "lastName"  => "Green",
                "firstName" => "Frances",
                "username"  => "green.frances",
                "email"     => "green.frances@example.org",
                "birthDate" => "1979-04-04 11:03:31"
            ],
            [
                "lastName"  => "Pollich",
                "firstName" => "Beth",
                "username"  => "pollich.beth",
                "email"     => "pollich.beth@example.com",
                "birthDate" => "1996-04-27 05:21:32"
            ],
            [
                "lastName"  => "Walsh",
                "firstName" => "Sedrick",
                "username"  => "walsh.sedrick",
                "email"     => "walsh.sedrick@example.org",
                "birthDate" => "1943-10-10 03:57:25"
            ],
            [
                "lastName"  => "Crooks",
                "firstName" => "Luella",
                "username"  => "crooks.luella",
                "email"     => "crooks.luella@example.com",
                "birthDate" => "2004-11-28 05:34:33"
            ],
            [
                "lastName"  => "Feil",
                "firstName" => "Jack",
                "username"  => "feil.jack",
                "email"     => "feil.jack@example.net",
                "birthDate" => "1976-11-16 21:29:22"
            ],
            [
                "lastName"  => "Braun",
                "firstName" => "Kurtis",
                "username"  => "braun.kurtis",
                "email"     => "braun.kurtis@example.net",
                "birthDate" => "1962-04-22 17:53:21"
            ],
            [
                "lastName"  => "Spinka",
                "firstName" => "Serenity",
                "username"  => "spinka.serenity",
                "email"     => "spinka.serenity@example.com",
                "birthDate" => "1963-07-29 04:08:31"
            ],
            [
                "lastName"  => "Fahey",
                "firstName" => "Hallie",
                "username"  => "fahey.hallie",
                "email"     => "fahey.hallie@example.com",
                "birthDate" => "1996-08-16 20:12:22"
            ],
            [
                "lastName"  => "Harber",
                "firstName" => "Giovanna",
                "username"  => "harber.giovanna",
                "email"     => "harber.giovanna@example.com",
                "birthDate" => "1965-08-01 16:03:31"
            ],
            [
                "lastName"  => "Mitchell",
                "firstName" => "Bridgette",
                "username"  => "mitchell.bridgette",
                "email"     => "mitchell.bridgette@example.net",
                "birthDate" => "1961-05-24 19:21:33"
            ],
            [
                "lastName"  => "Dietrich",
                "firstName" => "Retta",
                "username"  => "dietrich.retta",
                "email"     => "dietrich.retta@example.com",
                "birthDate" => "2003-03-06 00:55:31"
            ],
            [
                "lastName"  => "Pagac",
                "firstName" => "Destany",
                "username"  => "pagac.destany",
                "email"     => "pagac.destany@example.net",
                "birthDate" => "2003-08-25 13:45:00"
            ],
            [
                "lastName"  => "Sanford",
                "firstName" => "Porter",
                "username"  => "sanford.porter",
                "email"     => "sanford.porter@example.org",
                "birthDate" => "1938-10-29 14:02:38"
            ],
            [
                "lastName"  => "Breitenberg",
                "firstName" => "Gerardo",
                "username"  => "breitenberg.gerardo",
                "email"     => "breitenberg.gerardo@example.net",
                "birthDate" => "1959-05-20 09:45:16"
            ],
            [
                "lastName"  => "Heller",
                "firstName" => "Ebony",
                "username"  => "heller.ebony",
                "email"     => "heller.ebony@example.com",
                "birthDate" => "1938-10-14 19:28:52"
            ],
            [
                "lastName"  => "Howell",
                "firstName" => "Vladimir",
                "username"  => "howell.vladimir",
                "email"     => "howell.vladimir@example.net",
                "birthDate" => "1961-07-07 10:15:13"
            ],
            [
                "lastName"  => "Gaylord",
                "firstName" => "Zander",
                "username"  => "gaylord.zander",
                "email"     => "gaylord.zander@example.net",
                "birthDate" => "1926-05-05 19:55:40"
            ],
            [
                "lastName"  => "Hamill",
                "firstName" => "Stephan",
                "username"  => "hamill.stephan",
                "email"     => "hamill.stephan@example.org",
                "birthDate" => "1963-07-03 18:46:59"
            ],
            [
                "lastName"  => "Towne",
                "firstName" => "Dedrick",
                "username"  => "towne.dedrick",
                "email"     => "towne.dedrick@example.com",
                "birthDate" => "1949-03-29 07:32:49"
            ],
            [
                "lastName"  => "Hamill",
                "firstName" => "Harrison",
                "username"  => "hamill.harrison",
                "email"     => "hamill.harrison@example.net",
                "birthDate" => "1937-09-09 17:31:45"
            ],
            [
                "lastName"  => "Nienow",
                "firstName" => "Colten",
                "username"  => "nienow.colten",
                "email"     => "nienow.colten@example.org",
                "birthDate" => "1979-04-06 09:10:33"
            ],
            [
                "lastName"  => "Borer",
                "firstName" => "Myriam",
                "username"  => "borer.myriam",
                "email"     => "borer.myriam@example.org",
                "birthDate" => "1951-09-17 22:29:04"
            ],
            [
                "lastName"  => "Howe",
                "firstName" => "Tavares",
                "username"  => "howe.tavares",
                "email"     => "howe.tavares@example.org",
                "birthDate" => "1919-11-08 01:30:00"
            ],
            [
                "lastName"  => "Dietrich",
                "firstName" => "Agustina",
                "username"  => "dietrich.agustina",
                "email"     => "dietrich.agustina@example.com",
                "birthDate" => "1983-03-20 20:38:50"
            ],
            [
                "lastName"  => "Kautzer",
                "firstName" => "Vincenza",
                "username"  => "kautzer.vincenza",
                "email"     => "kautzer.vincenza@example.org",
                "birthDate" => "2011-07-27 10:45:35"
            ],
            [
                "lastName"  => "Cassin",
                "firstName" => "Evie",
                "username"  => "cassin.evie",
                "email"     => "cassin.evie@example.com",
                "birthDate" => "1959-06-02 21:14:33"
            ],
            [
                "lastName"  => "Rowe",
                "firstName" => "Percy",
                "username"  => "rowe.percy",
                "email"     => "rowe.percy@example.org",
                "birthDate" => "1925-12-15 01:37:08"
            ],
            [
                "lastName"  => "Kreiger",
                "firstName" => "Horace",
                "username"  => "kreiger.horace",
                "email"     => "kreiger.horace@example.com",
                "birthDate" => "1932-08-12 16:36:08"
            ],
            [
                "lastName"  => "Emmerich",
                "firstName" => "Gisselle",
                "username"  => "emmerich.gisselle",
                "email"     => "emmerich.gisselle@example.net",
                "birthDate" => "1978-01-23 03:40:38"
            ],
            [
                "lastName"  => "Macejkovic",
                "firstName" => "Travis",
                "username"  => "macejkovic.travis",
                "email"     => "macejkovic.travis@example.net",
                "birthDate" => "1930-08-09 08:59:07"
            ],
            [
                "lastName"  => "Weimann",
                "firstName" => "Berry",
                "username"  => "weimann.berry",
                "email"     => "weimann.berry@example.org",
                "birthDate" => "1965-03-17 20:17:16"
            ],
            [
                "lastName"  => "Schuppe",
                "firstName" => "Obie",
                "username"  => "schuppe.obie",
                "email"     => "schuppe.obie@example.net",
                "birthDate" => "1988-01-25 23:59:30"
            ],
            [
                "lastName"  => "Konopelski",
                "firstName" => "Price",
                "username"  => "konopelski.price",
                "email"     => "konopelski.price@example.com",
                "birthDate" => "1922-12-20 06:02:50"
            ],
            [
                "lastName"  => "Doyle",
                "firstName" => "Wava",
                "username"  => "doyle.wava",
                "email"     => "doyle.wava@example.com",
                "birthDate" => "1972-01-27 21:55:45"
            ],
            [
                "lastName"  => "Okuneva",
                "firstName" => "Melvina",
                "username"  => "okuneva.melvina",
                "email"     => "okuneva.melvina@example.com",
                "birthDate" => "1996-11-13 19:13:52"
            ],
            [
                "lastName"  => "Halvorson",
                "firstName" => "Chauncey",
                "username"  => "halvorson.chauncey",
                "email"     => "halvorson.chauncey@example.net",
                "birthDate" => "2010-04-06 23:42:49"
            ],
            [
                "lastName"  => "Morissette",
                "firstName" => "Federico",
                "username"  => "morissette.federico",
                "email"     => "morissette.federico@example.com",
                "birthDate" => "1924-01-08 20:04:24"
            ],
            [
                "lastName"  => "Rolfson",
                "firstName" => "Wellington",
                "username"  => "rolfson.wellington",
                "email"     => "rolfson.wellington@example.org",
                "birthDate" => "1942-10-04 07:41:51"
            ],
            [
                "lastName"  => "Aufderhar",
                "firstName" => "Daphney",
                "username"  => "aufderhar.daphney",
                "email"     => "aufderhar.daphney@example.org",
                "birthDate" => "1972-07-24 09:57:46"
            ],
            [
                "lastName"  => "Kulas",
                "firstName" => "Wava",
                "username"  => "kulas.wava",
                "email"     => "kulas.wava@example.net",
                "birthDate" => "1948-08-21 03:50:44"
            ],
            [
                "lastName"  => "Boyer",
                "firstName" => "Leland",
                "username"  => "boyer.leland",
                "email"     => "boyer.leland@example.net",
                "birthDate" => "2008-12-05 11:10:11"
            ],
            [
                "lastName"  => "Wiegand",
                "firstName" => "Javier",
                "username"  => "wiegand.javier",
                "email"     => "wiegand.javier@example.com",
                "birthDate" => "1929-03-28 07:13:46"
            ],
            [
                "lastName"  => "Glover",
                "firstName" => "Shanelle",
                "username"  => "glover.shanelle",
                "email"     => "glover.shanelle@example.com",
                "birthDate" => "1962-07-19 04:21:34"
            ],
            [
                "lastName"  => "Runte",
                "firstName" => "Albin",
                "username"  => "runte.albin",
                "email"     => "runte.albin@example.net",
                "birthDate" => "1992-10-12 07:24:06"
            ],
            [
                "lastName"  => "Rau",
                "firstName" => "Leta",
                "username"  => "rau.leta",
                "email"     => "rau.leta@example.com",
                "birthDate" => "1916-04-07 16:44:15"
            ],
            [
                "lastName"  => "Becker",
                "firstName" => "Florencio",
                "username"  => "becker.florencio",
                "email"     => "becker.florencio@example.org",
                "birthDate" => "1945-10-13 02:54:28"
            ],
            [
                "lastName"  => "Rogahn",
                "firstName" => "Velva",
                "username"  => "rogahn.velva",
                "email"     => "rogahn.velva@example.net",
                "birthDate" => "2012-03-29 20:45:28"
            ],
            [
                "lastName"  => "Kozey",
                "firstName" => "Lorena",
                "username"  => "kozey.lorena",
                "email"     => "kozey.lorena@example.com",
                "birthDate" => "1924-08-31 16:49:06"
            ],
            [
                "lastName"  => "Rolfson",
                "firstName" => "Madaline",
                "username"  => "rolfson.madaline",
                "email"     => "rolfson.madaline@example.net",
                "birthDate" => "1977-06-26 16:49:57"
            ],
            [
                "lastName"  => "Nikolaus",
                "firstName" => "Buck",
                "username"  => "nikolaus.buck",
                "email"     => "nikolaus.buck@example.com",
                "birthDate" => "1998-12-07 10:29:30"
            ],
            [
                "lastName"  => "Bernier",
                "firstName" => "Efren",
                "username"  => "bernier.efren",
                "email"     => "bernier.efren@example.com",
                "birthDate" => "2001-10-23 16:04:17"
            ],
            [
                "lastName"  => "Feest",
                "firstName" => "Elissa",
                "username"  => "feest.elissa",
                "email"     => "feest.elissa@example.com",
                "birthDate" => "1952-11-07 22:52:28"
            ],
            [
                "lastName"  => "Ledner",
                "firstName" => "Wilford",
                "username"  => "ledner.wilford",
                "email"     => "ledner.wilford@example.com",
                "birthDate" => "1967-10-07 07:45:14"
            ],
            [
                "lastName"  => "Bode",
                "firstName" => "Kaia",
                "username"  => "bode.kaia",
                "email"     => "bode.kaia@example.org",
                "birthDate" => "1994-11-24 04:09:19"
            ],
            [
                "lastName"  => "O'Connell",
                "firstName" => "Edythe",
                "username"  => "o'connell.edythe",
                "email"     => "o'connell.edythe@example.com",
                "birthDate" => "2013-05-29 06:17:02"
            ],
            [
                "lastName"  => "Nicolas",
                "firstName" => "Camila",
                "username"  => "nicolas.camila",
                "email"     => "nicolas.camila@example.net",
                "birthDate" => "1933-03-03 12:56:56"
            ],
            [
                "lastName"  => "Bahringer",
                "firstName" => "Tyra",
                "username"  => "bahringer.tyra",
                "email"     => "bahringer.tyra@example.org",
                "birthDate" => "1985-05-09 12:16:33"
            ],
            [
                "lastName"  => "Kulas",
                "firstName" => "Oran",
                "username"  => "kulas.oran",
                "email"     => "kulas.oran@example.com",
                "birthDate" => "2005-03-31 22:20:49"
            ],
            [
                "lastName"  => "Cartwright",
                "firstName" => "Wilmer",
                "username"  => "cartwright.wilmer",
                "email"     => "cartwright.wilmer@example.net",
                "birthDate" => "1987-07-23 05:34:32"
            ],
            [
                "lastName"  => "Hane",
                "firstName" => "Nyah",
                "username"  => "hane.nyah",
                "email"     => "hane.nyah@example.org",
                "birthDate" => "1950-01-22 18:47:17"
            ],
            [
                "lastName"  => "Toy",
                "firstName" => "Geo",
                "username"  => "toy.geo",
                "email"     => "toy.geo@example.net",
                "birthDate" => "1922-01-04 19:50:13"
            ],
            [
                "lastName"  => "Waters",
                "firstName" => "Jaydon",
                "username"  => "waters.jaydon",
                "email"     => "waters.jaydon@example.net",
                "birthDate" => "1931-02-05 03:08:52"
            ],
            [
                "lastName"  => "Homenick",
                "firstName" => "Jordane",
                "username"  => "homenick.jordane",
                "email"     => "homenick.jordane@example.org",
                "birthDate" => "1949-02-06 01:09:36"
            ],
            [
                "lastName"  => "Kemmer",
                "firstName" => "Verner",
                "username"  => "kemmer.verner",
                "email"     => "kemmer.verner@example.org",
                "birthDate" => "1971-04-03 02:29:15"
            ],
            [
                "lastName"  => "Hegmann",
                "firstName" => "Haylee",
                "username"  => "hegmann.haylee",
                "email"     => "hegmann.haylee@example.com",
                "birthDate" => "2013-09-01 14:55:02"
            ],
            [
                "lastName"  => "Rippin",
                "firstName" => "Aaron",
                "username"  => "rippin.aaron",
                "email"     => "rippin.aaron@example.net",
                "birthDate" => "1961-06-11 23:48:55"
            ],
            [
                "lastName"  => "Lowe",
                "firstName" => "Lydia",
                "username"  => "lowe.lydia",
                "email"     => "lowe.lydia@example.net",
                "birthDate" => "1939-06-25 17:38:14"
            ],
            [
                "lastName"  => "Connelly",
                "firstName" => "Danika",
                "username"  => "connelly.danika",
                "email"     => "connelly.danika@example.com",
                "birthDate" => "1921-08-28 17:12:08"
            ],
            [
                "lastName"  => "Feeney",
                "firstName" => "Ernesto",
                "username"  => "feeney.ernesto",
                "email"     => "feeney.ernesto@example.com",
                "birthDate" => "2004-09-24 20:18:25"
            ],
            [
                "lastName"  => "Connelly",
                "firstName" => "Arvel",
                "username"  => "connelly.arvel",
                "email"     => "connelly.arvel@example.net",
                "birthDate" => "1932-02-16 16:13:37"
            ],
            [
                "lastName"  => "McCullough",
                "firstName" => "Libbie",
                "username"  => "mccullough.libbie",
                "email"     => "mccullough.libbie@example.org",
                "birthDate" => "1955-12-22 17:12:43"
            ],
            [
                "lastName"  => "Thompson",
                "firstName" => "Velva",
                "username"  => "thompson.velva",
                "email"     => "thompson.velva@example.com",
                "birthDate" => "1967-06-05 17:09:25"
            ],
            [
                "lastName"  => "Mohr",
                "firstName" => "Delmer",
                "username"  => "mohr.delmer",
                "email"     => "mohr.delmer@example.com",
                "birthDate" => "1953-06-07 23:57:29"
            ],
            [
                "lastName"  => "Thiel",
                "firstName" => "Junius",
                "username"  => "thiel.junius",
                "email"     => "thiel.junius@example.net",
                "birthDate" => "1976-06-13 00:34:54"
            ],
            [
                "lastName"  => "Ledner",
                "firstName" => "Krystel",
                "username"  => "ledner.krystel",
                "email"     => "ledner.krystel@example.com",
                "birthDate" => "1974-06-22 13:44:32"
            ],
            [
                "lastName"  => "Schowalter",
                "firstName" => "Robyn",
                "username"  => "schowalter.robyn",
                "email"     => "schowalter.robyn@example.net",
                "birthDate" => "1926-02-20 04:27:19"
            ],
            [
                "lastName"  => "Hilll",
                "firstName" => "Frieda",
                "username"  => "hilll.frieda",
                "email"     => "hilll.frieda@example.net",
                "birthDate" => "1941-10-07 03:48:22"
            ],
            [
                "lastName"  => "Botsford",
                "firstName" => "Terrance",
                "username"  => "botsford.terrance",
                "email"     => "botsford.terrance@example.org",
                "birthDate" => "1928-07-15 11:00:22"
            ],
            [
                "lastName"  => "Macejkovic",
                "firstName" => "Osbaldo",
                "username"  => "macejkovic.osbaldo",
                "email"     => "macejkovic.osbaldo@example.net",
                "birthDate" => "1976-09-21 00:17:05"
            ],
            [
                "lastName"  => "Rippin",
                "firstName" => "Elza",
                "username"  => "rippin.elza",
                "email"     => "rippin.elza@example.net",
                "birthDate" => "1978-08-31 18:54:04"
            ],
            [
                "lastName"  => "Wyman",
                "firstName" => "Loy",
                "username"  => "wyman.loy",
                "email"     => "wyman.loy@example.net",
                "birthDate" => "1980-09-16 08:19:04"
            ],
            [
                "lastName"  => "Pouros",
                "firstName" => "Salma",
                "username"  => "pouros.salma",
                "email"     => "pouros.salma@example.com",
                "birthDate" => "1981-11-23 16:19:56"
            ],
            [
                "lastName"  => "Kilback",
                "firstName" => "Jessika",
                "username"  => "kilback.jessika",
                "email"     => "kilback.jessika@example.com",
                "birthDate" => "1958-10-10 01:25:17"
            ],
            [
                "lastName"  => "Prohaska",
                "firstName" => "Gregg",
                "username"  => "prohaska.gregg",
                "email"     => "prohaska.gregg@example.net",
                "birthDate" => "1958-08-28 11:37:30"
            ],
            [
                "lastName"  => "Considine",
                "firstName" => "Delilah",
                "username"  => "considine.delilah",
                "email"     => "considine.delilah@example.com",
                "birthDate" => "1948-11-10 14:58:12"
            ],
            [
                "lastName"  => "Bernier",
                "firstName" => "Lorenza",
                "username"  => "bernier.lorenza",
                "email"     => "bernier.lorenza@example.org",
                "birthDate" => "1968-05-09 02:27:30"
            ],
            [
                "lastName"  => "Hammes",
                "firstName" => "Zetta",
                "username"  => "hammes.zetta",
                "email"     => "hammes.zetta@example.net",
                "birthDate" => "1948-05-08 00:59:52"
            ],
            [
                "lastName"  => "Gibson",
                "firstName" => "Ulises",
                "username"  => "gibson.ulises",
                "email"     => "gibson.ulises@example.org",
                "birthDate" => "1988-07-04 13:36:25"
            ],
            [
                "lastName"  => "Carroll",
                "firstName" => "Myrna",
                "username"  => "carroll.myrna",
                "email"     => "carroll.myrna@example.net",
                "birthDate" => "1932-05-13 12:47:05"
            ],
            [
                "lastName"  => "Effertz",
                "firstName" => "Porter",
                "username"  => "effertz.porter",
                "email"     => "effertz.porter@example.org",
                "birthDate" => "2006-01-10 08:35:04"
            ],
            [
                "lastName"  => "Morissette",
                "firstName" => "Dahlia",
                "username"  => "morissette.dahlia",
                "email"     => "morissette.dahlia@example.org",
                "birthDate" => "2014-05-26 22:41:20"
            ],
            [
                "lastName"  => "Casper",
                "firstName" => "Emory",
                "username"  => "casper.emory",
                "email"     => "casper.emory@example.net",
                "birthDate" => "2012-03-08 12:15:14"
            ]
        ];
    }
}
