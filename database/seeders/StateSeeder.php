<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {

            $data = [
                // 'Abia' => [
                //     'zones' => [
                //         'Abia North' => ['Arochukwu', 'Bende', 'Isuikwuato', 'Ohafia', 'Umunneochi'],
                //         'Abia Central' => ['Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Umuahia North', 'Umuahia South', 'Osisioma'],
                //         'Abia South' => ['Aba North', 'Aba South', 'Obingwa', 'Ugwunagbo', 'Ukwa East', 'Ukwa West'],
                //     ]
                // ],
                'Adamawa' => [
                    'zones' => [
                        'Adamawa North' => ['Madagali', 'Maiha', 'Michika', 'Mubi North', 'Mubi South'],
                        'Adamawa Central' => ['Fufore', 'Girei', 'Hong', 'Song', 'Yola North', 'Yola South', 'Gombi'],
                        'Adamawa South' => ['Demsa', 'Ganye', 'Guyuk', 'Jada', 'Lamurde', 'Mayo Belwa', 'Numan', 'Shelleng', 'Toungo'],
                    ]
                ],
                // 'Akwa Ibom' => [
                //     'zones' => [
                //         'Akwa Ibom North-West' => ['Abak', 'Essien Udim', 'Etim Ekpo', 'Ika', 'Ikot Ekpene', 'Ini', 'Obot Akara', 'Oruk Anam', 'Ukanafun', 'Ukan-Ikot'], // Note: Usually 10 LGAs
                //         'Akwa Ibom North-East' => ['Etinan', 'Ibesikpo Asutan', 'Ibiono Ibom', 'Itu', 'Nsit Atai', 'Nsit Ibom', 'Nsit Ubium', 'Uruan', 'Uyo'],
                //         'Akwa Ibom South' => ['Eastern Obolo', 'Eket', 'Esit Eket', 'Ibeno', 'Ikot Abasi', 'Mbo', 'Mkpat Enin', 'Okobo', 'Onna', 'Oron', 'Udung Uko', 'Urue Offong/Oruko'],
                //     ]
                // ],
                // 'Anambra' => [
                //     'zones' => [
                //         'Anambra North' => ['Anambra East', 'Anambra West', 'Ayamelum', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Oyi'],
                //         'Anambra Central' => ['Anaocha', 'Awka North', 'Awka South', 'Dunukofia', 'Idemili North', 'Idemili South', 'Njikoka'],
                //         'Anambra South' => ['Aguata', 'Ekwusigo', 'Ihiala', 'Nnewi North', 'Nnewi South', 'Orumba North', 'Orumba South'],
                //     ]
                // ],
                'Bauchi' => [
                    'zones' => [
                        'Bauchi North' => ['Gamawa', 'Giade', 'Itas/Gadau', 'Jama’are', 'Katagum', 'Shira', 'Zaki'],
                        'Bauchi Central' => ['Damban', 'Darazo', 'Ganjuwa', 'Misau', 'Ningi', 'Warji'],
                        'Bauchi South' => ['Alkaleri', 'Bauchi', 'Bogoro', 'Dass', 'Kirfi', 'Tafawa Balewa', 'Toro'],
                    ]
                ],
                // 'Bayelsa' => [
                //     'zones' => [
                //         'Bayelsa Central' => ['Kolokuma/Opokuma', 'Southern Ijaw', 'Yenagoa'],
                //         'Bayelsa East' => ['Brass', 'Nembe', 'Ogbia'],
                //         'Bayelsa West' => ['Ekeremor', 'Sagbama'],
                //     ]
                // ],
                // 'Benue' => [
                //     'zones' => [
                //         'Benue North-East' => ['Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Ukum', 'Ushongo', 'Vandeikya'],
                //         'Benue North-West' => ['Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Makurdi', 'Tarka'],
                //         'Benue South' => ['Ado', 'Agatu', 'Apa', 'Obi', 'Ogbadibo', 'Ohimini', 'Okpokwu', 'Otukpo'],
                //     ]
                // ],
                // 'Borno' => [
                //     'zones' => [
                //         'Borno North' => ['Abadam', 'Gubio', 'Guzamala', 'Kaga', 'Kukawa', 'Magumeri', 'Marte', 'Mobbar', 'Monguno', 'Nganzai'],
                //         'Borno Central' => ['Bama', 'Dikwa', 'Jere', 'Kala/Balge', 'Konduga', 'Mafa', 'Maiduguri', 'Ngala'],
                //         'Borno South' => ['Askira/Uba', 'Bayo', 'Biu', 'Chibok', 'Damboa', 'Gwoza', 'Hawul', 'Kwaya Kusar', 'Shani'],
                //     ]
                // ],
                'Cross River' => [
                    'zones' => [
                        'Cross River North' => ['Bekwarra', 'Obanliku', 'Obudu', 'Ogoja', 'Yala'],
                        'Cross River Central' => ['Abi', 'Boki', 'Etung', 'Ikom', 'Obubra', 'Yakurr'],
                        'Cross River South' => ['Akamkpa', 'Akpabuyo', 'Bakassi', 'Biase', 'Calabar Municipal', 'Calabar South', 'Odukpani'],
                    ]
                ],
                // 'Delta' => [
                //     'zones' => [
                //         'Delta North' => ['Aniocha North', 'Aniocha South', 'Ika North East', 'Ika South', 'Ndokwa East', 'Ndokwa West', 'Oshimili North', 'Oshimili South', 'Ukwuani'],
                //         'Delta Central' => ['Ethiope East', 'Ethiope West', 'Okpe', 'Sapele', 'Udu', 'Ughelli North', 'Ughelli South', 'Uvwie'],
                //         'Delta South' => ['Bomadi', 'Burutu', 'Isoko North', 'Isoko South', 'Patani', 'Warri North', 'Warri South', 'Warri South West'],
                //     ]
                // ],
                // 'Ebonyi' => [
                //     'zones' => [
                //         'Ebonyi North' => ['Abakaliki', 'Ebonyi', 'Izzi', 'Ohaukwu'],
                //         'Ebonyi Central' => ['Ezza North', 'Ezza South', 'Ikwo', 'Ishielu'],
                //         'Ebonyi South' => ['Afikpo North', 'Afikpo South', 'Ivo', 'Ohaozara', 'Onicha'],
                //     ]
                // ],
                // 'Edo' => [
                //     'zones' => [
                //         'Edo North' => ['Akoko-Edo', 'Etsako Central', 'Etsako East', 'Etsako West', 'Owan East', 'Owan West'],
                //         'Edo Central' => ['Esan Central', 'Esan North East', 'Esan South East', 'Esan West', 'Igueben'],
                //         'Edo South' => ['Egor', 'Ikpoba Okha', 'Oredo', 'Orhionmwon', 'Ovia North East', 'Ovia South West', 'Uhunmwonde'],
                //     ]
                // ],
                // 'Ekiti' => [
                //     'zones' => [
                //         'Ekiti North' => ['Ido Osi', 'Ilejemeje', 'Irepodun/Ifelodun', 'Moba', 'Oye', 'Ikole'],
                //         'Ekiti Central' => ['Ado Ekiti', 'Efon', 'Ekiti West', 'Ijero', 'Irepo'],
                //         'Ekiti South' => ['Ekiti East', 'Ekiti South West', 'Emure', 'Gbonyin', 'Ikere', 'Ise/Orun'],
                //     ]
                // ],
                // 'Enugu' => [
                //     'zones' => [
                //         'Enugu East' => ['Enugu East', 'Enugu North', 'Enugu South', 'Isi Uzo', 'Nkanu East', 'Nkanu West'],
                //         'Enugu North' => ['Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Nsukka', 'Udenu', 'Uzo Uwani'],
                //         'Enugu West' => ['Aninri', 'Awgu', 'Ezeagu', 'Oji River', 'Udi'],
                //     ]
                // ],
                'Gombe' => [
                    'zones' => [
                        'Gombe North' => ['Dukku', 'Funakaye', 'Gombe', 'Kwami', 'Nafada'],
                        'Gombe Central' => ['Akko', 'Yamaltu/Deba'],
                        'Gombe South' => ['Balanga', 'Billiri', 'Kaltungo', 'Shongom'],
                    ]
                ],
                // 'Imo' => [
                //     'zones' => [
                //         'Imo East' => ['Aboh Mbaise', 'Ahiazu Mbaise', 'Ezinihitte', 'Ikeduru', 'Mbaitoli', 'Ngor Okpala', 'Owerri Municipal', 'Owerri North', 'Owerri West'],
                //         'Imo North' => ['Ehime Mbano', 'Ihitte/Uboma', 'Isiala Mbano', 'Obowo', 'Okigwe', 'Onuimo'],
                //         'Imo West' => ['Ideato North', 'Ideato South', 'Isu', 'Njaba', 'Nkwerre', 'Nwangele', 'Oguta', 'Ohaji/Egbema', 'Orlu', 'Orsu', 'Oru East', 'Oru West'],
                //     ]
                // ],
                // 'Jigawa' => [
                //     'zones' => [
                //         'Jigawa North-West' => ['Babura', 'Garki', 'Gumel', 'Gwiwa', 'Kazaure', 'Maigatari', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'],
                //         'Jigawa North-East' => ['Auyo', 'Birniwa', 'Guri', 'Hadejia', 'Kafin Hausa', 'Kaugama', 'Kiri Kasama', 'Malam Madori'],
                //         'Jigawa South-West' => ['Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Gwaram', 'Jahun', 'Kiyawa', 'Miga'],
                //     ]
                // ],
                // 'Kaduna' => [
                //     'zones' => [
                //         'Kaduna North' => ['Giwa', 'Ikara', 'Kudan', 'Makarfi', 'Sabon Gari', 'Soba', 'Zaria'],
                //         'Kaduna Central' => ['Birnin Gwari', 'Chikun', 'Igabi', 'Kaduna North', 'Kaduna South', 'Kajuru'],
                //         'Kaduna South' => ['Jaba', 'Jema’a', 'Kachia', 'Kagarko', 'Kaura', 'Kauru', 'Lere', 'Sanga', 'Zangon Kataf'],
                //     ]
                // ],
                'Kano' => [
                    'zones' => [
                        'Kano North' => ['Bagwai', 'Bichi', 'Dambatta', 'Dawakin Tofa', 'Gwarzo', 'Kabo', 'Kunchi', 'Makoda', 'Minjibir', 'Rimin Gado', 'Shanono', 'Tofa', 'Tsanyawa'],
                        'Kano Central' => ['Dala', 'Dawakin Kudu', 'Fagge', 'Garu Mallam', 'Gezawa', 'Gwale', 'Kano Municipal', 'Kumbotso', 'Kura', 'Madobi', 'Nassarawa', 'Tarauni', 'Ungogo', 'Warawa'],
                        'Kano South' => ['Ajingi', 'Albasu', 'Bebeji', 'Bunkure', 'Doguwa', 'Gaya', 'Kiru', 'Rano', 'Rogo', 'Sumaila', 'Takai', 'Tudun Wada', 'Wudil'],
                    ]
                ],
                // 'Katsina' => [
                //     'zones' => [
                //         'Katsina North' => ['Baure', 'Bindawa', 'Daura', 'Dutsi', 'Ingawa', 'Kaita', 'Mani', 'Mashi', 'Mai’Adua', 'Sandamu', 'Zango'],
                //         'Katsina Central' => ['Batagarawa', 'Batsari', 'Charanchi', 'Dan Musa', 'Dutsin Ma', 'Jibia', 'Kankia', 'Katsina', 'Kurfi', 'Rimi', 'Safana'],
                //         'Katsina South' => ['Bakori', 'Danja', 'Dandume', 'Faskari', 'Funtua', 'Kafur', 'Kankara', 'Malumfashi', 'Matazu', 'Musawa', 'Sabuwa'],
                //     ]
                // ],
                // 'Kebbi' => [
                //     'zones' => [
                //         'Kebbi North' => ['Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Bunza', 'Dandi', 'Suru'],
                //         'Kebbi Central' => ['Aleiro', 'Birnin Kebbi', 'Gwandu', 'Jega', 'Kalgo', 'Koko/Besse', 'Maiyama'],
                //         'Kebbi South' => ['Danko/Wasagu', 'Fakai', 'Ngaski', 'Sakaba', 'Shanga', 'Yauri', 'Zuru'],
                //     ]
                // ],
                // 'Kogi' => [
                //     'zones' => [
                //         'Kogi East' => ['Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela-Odolu', 'Ofu', 'Olamaboro', 'Omala'],
                //         'Kogi Central' => ['Adavi', 'Ajaokuta', 'Ogori/Magongo', 'Okehi', 'Okene'],
                //         'Kogi West' => ['Ijumu', 'Kabba/Bunu', 'Kogi', 'Lokoja', 'Mopa Muro', 'Yagba East', 'Yagba West'],
                //     ]
                // ],
                // 'Kwara' => [
                //     'zones' => [
                //         'Kwara North' => ['Baruten', 'Edu', 'Kaiama', 'Moro', 'Pategi'],
                //         'Kwara Central' => ['Asa', 'Ilorin East', 'Ilorin South', 'Ilorin West'],
                //         'Kwara South' => ['Ekiti', 'Ifelodun', 'Irepodun', 'Isin', 'Offa', 'Oke Ero', 'Oyun'],
                //     ]
                // ],
                // 'Lagos' => [
                //     'zones' => [
                //         'Lagos West' => ['Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Badagry', 'Ifako-Ijaiye', 'Ikeja', 'Mushin', 'Ojo', 'Oshodi-Isolo'],
                //         'Lagos Central' => ['Apapa', 'Eti Osa', 'Lagos Island', 'Lagos Mainland', 'Surulere'],
                //         'Lagos East' => ['Epe', 'Ibeju-Lekki', 'Ikorodu', 'Kosofe', 'Somolu'],
                //     ]
                // ],
                // 'Nasarawa' => [
                //     'zones' => [
                //         'Nasarawa North' => ['Akwanga', 'Nasarawa Egon', 'Wamba'],
                //         'Nasarawa Central' => ['Doma', 'Keana', 'Lafia', 'Nassarawa Eggon', 'Obi'], // Also known as Nasarawa South
                //         'Nasarawa West' => ['Karu', 'Keffi', 'Kokona', 'Nasarawa', 'Toto'],
                //     ]
                // ],
                // 'Niger' => [
                //     'zones' => [
                //         'Niger North' => ['Agwara', 'Borgu', 'Kontagora', 'Magama', 'Mariga', 'Mashegu', 'Rijau', 'Wushishi'],
                //         'Niger East' => ['Chanchaga', 'Gurara', 'Bosso', 'Paikoro', 'Munya', 'Rafi', 'Shiroro', 'Suleja', 'Tafa'],
                //         'Niger South' => ['Agaie', 'Bida', 'Edati', 'Gbako', 'Katcha', 'Lapai', 'Lavun', 'Mokwa'],
                //     ]
                // ],
                // 'Ogun' => [
                //     'zones' => [
                //         'Ogun East' => ['Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Odogbolu', 'Ogun Waterside', 'Remo North', 'Sagamu'],
                //         'Ogun Central' => ['Abeokuta North', 'Abeokuta South', 'Ewekoro', 'Ifo', 'Obafemi Owode', 'Odeda'],
                //         'Ogun West' => ['Ado-Odo/Ota', 'Imeko Afon', 'Ipokia', 'Yewa North', 'Yewa South'],
                //     ]
                // ],
                // 'Ondo' => [
                //     'zones' => [
                //         'Ondo North' => ['Akoko North East', 'Akoko North West', 'Akoko South East', 'Akoko South West', 'Ose', 'Owo'],
                //         'Ondo Central' => ['Akure North', 'Akure South', 'Idanre', 'Ifedore', 'Ondo East', 'Ondo West'],
                //         'Ondo South' => ['Ese Odo', 'Ilaje', 'Ile-Oluji/Okeigbo', 'Irele', 'Odigbo', 'Okitipupa'],
                //     ]
                // ],
                // 'Osun' => [
                //     'zones' => [
                //         'Osun East' => ['Atakumosa East', 'Atakumosa West', 'Ife Central', 'Ife East', 'Ife North', 'Ife South', 'Ilesa East', 'Ilesa West', 'Obokun', 'Oriade'],
                //         'Osun Central' => ['Bolowaduro', 'Boripe', 'Ifedayo', 'Ifelodun', 'Ila', 'Irepodun', 'Odo Otin', 'Ola Oluwa', 'Olorunda', 'Osogbo'],
                //         'Osun West' => ['Aiyedaade', 'Aiyedire', 'Ede North', 'Ede South', 'Egbedore', 'Ejigbo', 'Isokan', 'Iwo', 'Irewole'],
                //     ]
                // ],
                // 'Oyo' => [
                //     'zones' => [
                //         'Oyo North' => ['Atisbo', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola', 'Olorunsogo', 'Oorelope', 'Saki East', 'Saki West', 'Ogbomosho North', 'Ogbomosho South', 'Orire'],
                //         'Oyo Central' => ['Afijio', 'Akinyele', 'Egbeda', 'Lagelu', 'Ogo Oluwa', 'Ona Ara', 'Oyo East', 'Oyo West', 'Surulere', 'Atiba'],
                //         'Oyo South' => ['Ibadan North', 'Ibadan North East', 'Ibadan North West', 'Ibadan South East', 'Ibadan South West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North', 'Ido'],
                //     ]
                // ],
                // 'Plateau' => [
                //     'zones' => [
                //         'Plateau North' => ['Barkin Ladi', 'Bassa', 'Jos East', 'Jos North', 'Jos South', 'Riyom'],
                //         'Plateau Central' => ['Bokkos', 'Kanam', 'Kanke', 'Mangu', 'Pankshin'],
                //         'Plateau South' => ['Langtang North', 'Langtang South', 'Mikang', 'Qua’an Pan', 'Shendam', 'Wase'],
                //     ]
                // ],
                // 'Rivers' => [
                //     'zones' => [
                //         'Rivers East' => ['Etche', 'Ikwerre', 'Obio/Akpor', 'Ogu/Bolo', 'Okrika', 'Omuma', 'Port Harcourt'],
                //         'Rivers South-East' => ['Andoni', 'Eleme', 'Gokana', 'Khana', 'Opobo/Nkoro', 'Oyigbo', 'Tai'],
                //         'Rivers West' => ['Abua/Odual', 'Ahoada East', 'Ahoada West', 'Akuku Toru', 'Asari Toru', 'Bonny', 'Degema', 'Emohua'],
                //     ]
                // ],
                // 'Sokoto' => [
                //     'zones' => [
                //         'Sokoto North' => ['Binji', 'Gudu', 'Illela', 'Kware', 'Silame', 'Sokoto North', 'Sokoto South', 'Tangaza', 'Wamako'],
                //         'Sokoto East' => ['Gada', 'Goronyo', 'Isa', 'Rabah', 'Sabon Birni', 'Wurno'],
                //         'Sokoto South' => ['Bodinga', 'Dange Shuni', 'Kebbe', 'Shagari', 'Tambuwal', 'Tureta', 'Yabo'],
                //     ]
                // ],
                // 'Taraba' => [
                //     'zones' => [
                //         'Taraba North' => ['Ardo Kola', 'Jalingo', 'Karim Lamido', 'Lau', 'Yorro', 'Zing'],
                //         'Taraba Central' => ['Bali', 'Gashaka', 'Gassol', 'Kurmi', 'Sardauna'],
                //         'Taraba South' => ['Donga', 'Ibi', 'Takum', 'Ussa', 'Wukari'],
                //     ]
                // ],
                // 'Yobe' => [
                //     'zones' => [
                //         'Yobe North' => ['Bade', 'Jakusko', 'Karasuwa', 'Machina', 'Nguru', 'Yusufari'],
                //         'Yobe East' => ['Bursari', 'Damaturu', 'Geidam', 'Gujba', 'Gulani', 'Tarmuwa', 'Yunusari'],
                //         'Yobe South' => ['Fika', 'Fune', 'Nangere', 'Potiskum'],
                //     ]
                // ],
                'Zamfara' => [
                    'zones' => [
                        'Zamfara North' => ['Birnin Magaji/Kiyaw', 'Kaura Namoda', 'Shinkafi', 'Zurmi'],
                        'Zamfara Central' => ['Bungudu', 'Gusau', 'Maru', 'Tsafe'],
                        'Zamfara West' => ['Anka', 'Bakura', 'Bukkuyum', 'Gummi', 'Maradun', 'Talata Mafara'],
                    ]
                ],
                // 'FCT' => [
                //     'zones' => [
                //         'FCT' => ['Abaji', 'Abuja Municipal', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali']
                //     ]
                // ],
            ];

            foreach ($data as $stateName => $stateData) {

                $stateId = DB::table('states')->insertGetId([
                    'name' => $stateName,
                    'description' => "$stateName State",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($stateData['zones'] as $zoneName => $lgas) {

                    $zoneId = DB::table('zones')->insertGetId([
                        'name' => $zoneName,
                        'state_id' => $stateId,
                        'description' => "$zoneName Senatorial Zone",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    foreach ($lgas as $lga) {
                        DB::table('lgas')->insert([
                            'name' => $lga,
                            'state_id' => $stateId,
                            'zone_id' => $zoneId,
                            'description' => "$lga LGA",
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        });
    }
}
