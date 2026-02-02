<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\Ward;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Adamawa' => [
                'Madagali' => ['Babal', 'Gulak', 'Hyambula', 'Kirdi / Wurongayandi', 'Madagali', 'Pallam', 'Shelmi / Sukur / Vapura', 'Wagga', 'Wula'],
                'Maiha' => ['Belel', 'Humbutudi', 'Konkol', 'Maiha Gari', 'Manjekin', 'Mayobe', 'Paka', 'Sorau A', 'Sorau B', 'Tambajam'],
                'Michika' => ['Bazza Margi', 'Futudou / Futules', 'Garta / Ghunchi', 'Jigalambu', 'Madzi', 'Michika I', 'Michika II', 'Minkisi / Wuro Ngiki', 'Moda / Dlaka / Ghenjuwa', 'Munka Vicita', 'Sina / Kwande', 'Thukudou / Sufuku / Zah', 'Tsukumu / Tillijo', 'Tumbara / Ngabili', 'Vi / Boka', 'Wamblimi / Tilli'],
                'Mubi North' => ['Bahuli', 'Betso', 'Digil', 'Kolere', 'Lokuwa', 'Mayo Bani', 'Muchalla', 'Sabon Yelwa', 'Vimtim', 'Yelwa'],
                'Mubi South' => ['Chamba', 'Gella', 'Gude', 'Kwaja', 'Lamorde', 'Mugulbu', 'Mujara', 'Nassarawo', 'Nduku', 'Yelwa'],
                'Fufore' => ['Farang', 'Fufore', 'Gurin', 'Karlahi', 'Mayo Ine', 'Pariya', 'Ribadu', 'Uba', 'Verre', 'Wuro Boki'],
                'Girei' => ['Dakri', 'Damare', 'Girei I', 'Girei II', 'Gereng', 'Jauro Tongo', 'Modire', 'Tambo', 'Wuro Dole'],
                'Hong' => ['Bangshika', 'Daksiri', 'Gaya', 'Garaha', 'Hong', 'Hussara', 'Kwarhi', 'Mayo Lope', 'Shangui', 'Thilbang', 'Uba'],
                'Song' => ['Dirma', 'Dumne', 'Gudu / Mboi', 'Kilange Funa', 'Kilange Hirna', 'Song Gari', 'Song Loko', 'Suktu', 'Wuro-Mane', 'Zumo'],
                'Yola North' => ['Ajiya', 'Alkalawa', 'Doubeli', 'Gwadabawa', 'Jambutu', 'Karewa', 'Limawa', 'Luggere', 'Nassarawo', 'Rumde', 'Yelwa'],
                'Yola South' => ['Adarawo', 'Bako', 'Bole Yolde Pate', 'Makama A', 'Makama B', 'Mbamba', 'Mbamoi', 'Namtari', 'Ngurore', 'Yolde Kohi'],
                'Gombi' => ['Boga / Dingai', 'Duwa', 'Ga’anda', 'Garkida', 'Gombi North', 'Gombi South', 'Guyaku', 'Tawa', 'Yang'],
                'Demsa' => ['Bille', 'Bororong', 'Demsa', 'Dilli', 'Gwamba', 'Koppa', 'Mbula Kuli', 'Ndong', 'Old Demsa', 'Yankam'],
                'Ganye' => ['Bakari Guso', 'Ganye I', 'Ganye II', 'Guringa', 'Jaggu', 'Sangasumi', 'Sugu', 'Yebbi'],
                'Guyuk' => ['Banjiram', 'Bobini', 'Bodeno', 'Chikila', 'Dumna', 'Guyuk', 'Kola', 'Lokoro', 'Purokayo'],
                'Jada' => ['Danaba', 'Jada I', 'Jada II', 'Koma I', 'Koma II', 'Leko', 'Mapeo', 'Mbulo', 'Nyibango', 'Yelli'],
                'Lamurde' => ['Gyawana', 'Lafiya', 'Lamurde', 'Mgbeioro', 'Ngbakowo', 'Suwa', 'Waduku', 'Zekun'],
                'Mayo Belwa' => ['Bajama', 'Binyeri', 'Gengle', 'Gorobi', 'Mayo Belwa', 'Nassarawo', 'Ribadu', 'Tola', 'Yoffo', 'Zumo'],
                'Numan' => ['Bare', 'Bolki', 'Gamadio', 'Imburu', 'Kodomti', 'Numan I', 'Numan II', 'Numan III', 'Sabon Pegi', 'Vulpi'],
                'Shelleng' => ['Bakta', 'Bodwai', 'Gundo', 'Jabbure', 'Kiri', 'Libbo', 'Shelleng', 'Tallum'],
                'Toungo' => ['Dawo I', 'Dawo II', 'Gumti', 'Kiri', 'Toungo I', 'Toungo II']
            ],
            'Bauchi' => [
                'Gamawa' => ['Alagarno', 'Gamawa', 'Gadiya', 'Gololo', 'Kubdiya', 'Kafin Romi', 'Kubdiya', 'Raga', 'Tarmuwa', 'Udobo'],
                'Giade' => ['Chinkani', 'Doguwa', 'Giade', 'Isawa', 'Jugudu', 'Uzum', 'Zabi'],
                'Itas/Gadau' => ['Buzawa', 'Gadau', 'Gwarai', 'Itas', 'Kashuri', 'Magarya', 'Mashema'],
                'Jama’are' => ['Dogon Jeji', 'Galdimari', 'Hanafunari', 'Jama’are A', 'Jama’are B', 'Jama’are C', 'Jurara'],
                'Katagum' => ['Bulu', 'Chinade', 'Gambaki', 'Madachi', 'Madangala', 'Madara', 'Nasarawo', 'Ragwam', 'Tshidi', 'Yayu'],
                'Shira' => ['Beli', 'Faggo', 'Shira', 'Tsafi', 'Tumfafi', 'Zubo'],
                'Zaki' => ['Bursali', 'Gumai', 'Katagum', 'Mainako', 'Murmur', 'Sakwa', 'Tandari', 'Zaki'],
                'Damban' => ['Damban', 'Dagauda', 'Gargawa', 'Garu', 'Jalam', 'Yanda', 'Zaura'],
                'Darazo' => ['Darazo', 'Gabarin', 'Gau', 'Lanzai', 'Papa', 'Sade', 'Tauya', 'Wahu'],
                'Ganjuwa' => ['Ganjuwa', 'Gungura', 'Kafin Madaki', 'Kariya', 'Miya', 'Ningi', 'Yali'],
                'Misau' => ['Ajuji', 'Gwaram', 'Hardawa', 'Jarkasa', 'Kukadi', 'Misau', 'Sarma', 'Sirko'],
                'Ningi' => ['Balma', 'Burra', 'Gudu', 'Kudu', 'Kurmi', 'Ningi', 'Nasaru', 'Tiffi'],
                'Warji' => ['Baima', 'Dagu', 'Gwadaba', 'Ranga', 'Tura', 'Warji'],
                'Alkaleri' => ['Alkaleri', 'Futuk', 'Gwana', 'Maimadi', 'Pali', 'Yali'],
                'Bauchi' => ['Birshi', 'Dandango', 'Dan’iya', 'Dawaki', 'Galambi', 'Kangal', 'Majidadi A', 'Majidadi B', 'Makama B', 'Mun', 'Zungur'],
                'Bogoro' => ['Bogoro A', 'Bogoro B', 'Bogoro C', 'Bogoro D', 'Gwaranga', 'Tadnum'],
                'Dass' => ['Bundot', 'Dass', 'Durr', 'Polchi', 'Wandi', 'Zumbul'],
                'Kirfi' => ['Bara', 'Dewu', 'Kirfi', 'Wuro', 'Zange'],
                'Tafawa Balewa' => ['Bununu', 'Dull', 'Lere', 'Tafawa Balewa', 'Wai'],
                'Toro' => ['Jama’a', 'Lame', 'Ribina', 'Toro', 'Wonu', 'Zalau']
            ],
            'Cross River' => [
                'Bekwarra' => ['Abouchiche', 'Afrike Okpeche', 'Afrike Ochagbe', 'Bekwarra', 'Gakem', 'Ibiaragidi', 'Ugboro'],
                'Obanliku' => ['Basang', 'Bendi I', 'Bendi II', 'Bishiri North', 'Bishiri South', 'Busi', 'Obanliku', 'Utanga'],
                'Obudu' => ['Abelebale', 'Angiaba', 'Begiaba', 'Ipong', 'Obudu', 'Utugwang North', 'Utugwang South'],
                'Ogoja' => ['Ekajuk I', 'Ekajuk II', 'Mbube East I', 'Mbube East II', 'Mbube West I', 'Mbube West II', 'Nkum Ibekpa', 'Nkum Irede', 'Ogoja Urban I', 'Ogoja Urban II'],
                'Yala' => ['Echumofana', 'Gabbu', 'Ijegu', 'Okpoma', 'Okuku', 'Ukele North', 'Ukele South', 'Yahe', 'Yala'],
                'Abi' => ['Adadama', 'Afafanyi', 'Ebom', 'Ediba', 'Itigidi', 'Usumutong'],
                'Boki' => ['Boki Dist', 'Boje', 'Irruan', 'Kakwagom', 'Nsadop', 'Okundi', 'Osokom'],
                'Etung' => ['Abia', 'Ajassor', 'Bendeghe Ekiem', 'Etung', 'Effraya', 'Itokem'],
                'Ikom' => ['Ikom Urban', 'Nde', 'Nnam', 'Ofutop I', 'Ofutop II', 'Olulumo'],
                'Obubra' => ['Ababene', 'Adun', 'Apiapum', 'Obubra Urban', 'Ofat', 'Ofumbongha', 'Osopong I', 'Osopong II'],
                'Yakurr' => ['Agoi-Ekpo', 'Agoi-Ibami', 'Asaga', 'Ekori I', 'Ekori II', 'Ibom', 'Idomi', 'Mkpani', 'Nko', 'Ugep I', 'Ugep II'],
                'Akamkpa' => ['Akamkpa Urban', 'Ehom', 'Ekpi', 'Iko-Ekperem', 'Ikpai', 'Ojuk North', 'Ojuk South'],
                'Akpabuyo' => ['Atimbo East', 'Atimbo West', 'Eneyo', 'Ikane', 'Ikot Edem', 'Ikot Nakanda'],
                'Bakassi' => ['Akpa-Yafe', 'Archibong', 'Enwang', 'Kosi', 'Odiong'],
                'Biase' => ['Adim', 'Agwagwune', 'Akpet', 'Ehom', 'Ikun', 'Umon'],
                'Calabar Municipal' => ['Ward 1', 'Ward 2', 'Ward 3', 'Ward 4', 'Ward 5', 'Ward 6', 'Ward 7', 'Ward 8', 'Ward 9', 'Ward 10'],
                'Calabar South' => ['Ward 1', 'Ward 2', 'Ward 3', 'Ward 4', 'Ward 5', 'Ward 6', 'Ward 7', 'Ward 8', 'Ward 9', 'Ward 10', 'Ward 11', 'Ward 12'],
                'Odukpani' => ['Adiabo/Efutu', 'Akamkpa', 'Eki', 'Ito', 'Netim', 'Odukpani Central']
            ],
            'Gombe' => [
                'Dukku' => ['Dukku Central', 'Dukku South', 'Gombe Abba', 'Hashidu', 'Jamari', 'Kunde', 'Lafiya', 'Malala', 'Waziri North', 'Waziri South', 'Wuro Tale', 'Zange', 'Zaune'],
                'Funakaye' => ['Ashaka', 'Bajoga East', 'Bajoga West', 'Bage', 'Jillahi', 'Ribadu', 'Tilde', 'Tongo'],
                'Gombe' => ['Ajiya', 'Bajoga', 'Bolari East', 'Bolari West', 'Dawaki', 'Herwagana', 'Jekadafari', 'Kumbiya-Kumbiya', 'Nassarawo', 'Pantami', 'Shamaki'],
                'Kwami' => ['Boal / Pindi', 'Daban Fulani', 'Doho', 'Duku', 'Gadam', 'Kwami', 'Mallam Sidi'],
                'Nafada' => ['Barwo / Nafada', 'Gadi', 'Jigawa', 'Munda'],
                'Akko' => ['Akko', 'Garko', 'Kalshingi', 'Kashere', 'Kumo Central', 'Kumo East', 'Kumo North', 'Kumo West', 'Pindiga', 'Tukulma', 'Tumu'],
                'Yamaltu/Deba' => ['Deba', 'Difa / Lubamoto', 'Gwani', 'Jagali', 'Kanawa', 'Kunuwal', 'Wade', 'Yamaltu'],
                'Balanga' => ['Balanga', 'Bambam', 'Gelengu', 'Kindiyo', 'Swa', 'Talasse'],
                'Billiri' => ['Bare', 'Billiri North', 'Billiri South', 'Kalshigi', 'Tudu'],
                'Kaltungo' => ['Awak', 'Kaltungo East', 'Kaltungo West', 'Tula Baule', 'Tula Wange'],
                'Shongom' => ['Boh', 'Filiya', 'Gunda', 'Lalaipido', 'Shongom']
            ],
            'Kano' => [
                // Urban LGAs
                'Dala' => ['Adakawa', 'Bakin Zuwo', 'Dala', 'Dogon Nama', 'Gobirawa', 'Gwammaja', 'Kabuwaya', 'Kantudu', 'Kofar Mazugal', 'Kofar Ruwa', 'Madigawa', 'Yalwa'],
                'Fagge' => ['Fagge A', 'Fagge B', 'Fagge C', 'Fagge D', 'Fagge E', 'Kwachiri', 'Rijiyar Lemo', 'Sabon Gari East', 'Sabon Gari West', 'Yammata'],
                'Kano Municipal' => ['Chedi', 'Dan’Agundi', 'Gandun Albasa', 'Jakara', 'Kankarofi', 'Shahuchi', 'Sharada', 'Sheshe', 'Tudun Nufawa', 'Tudun Wazirchi', 'Zaitawa'],
                'Gwale' => ['Dandago', 'Diso', 'Galadanchi', 'Goron Dutse', 'Gwale', 'Gyan-Gyan', 'Mandawari', 'Sani Mainage', 'Warure'],
                'Tarauni' => ['Darmanawa', 'Hotoro North', 'Hotoro South', 'Tarauni', 'Unguwar Gano', 'Unguwa Uku C', 'Unguwa Uku East', 'Unguwa Uku West'],
                'Nassarawa' => ['Dakata', 'Gwagwarwa', 'Gama', 'Kauru', 'Nassarawa', 'Tudun Murtala', 'Tudun Wada'],
                'Ungogo' => ['Bachirawa', 'Gayawa', 'Kadaure', 'Panisau', 'Rimin Kebe', 'Tudun Fulani', 'Ungogo', 'Zango'],
                'Kumbotso' => ['Chiranchi', 'Danbare', 'Guringawa', 'Kumbotso', 'Mariri', 'Na’ibawa', 'Panshekara', 'Unguwar Rimi'],

                // Kano North
                'Bagwai' => ['Bagwai', 'Daddauda', 'Gadangau', 'Gogori', 'Kiyawa', 'Kwajali', 'Rimaye', 'Rumi', 'Sare-Sare', 'Wuro Bagga'],
                'Bichi' => ['Bichi', 'Badume', 'Danzabuwa', 'Fagwalawa', 'Kyalli', 'Muntsira', 'Saye', 'Waire', 'Yallami'],
                'Dambatta' => ['Dambatta East', 'Dambatta West', 'Fajewa', 'Gwanda', 'Gwarabjawa', 'Koren Tabo', 'Saidawa', 'Sansan'],
                'Dawakin Tofa' => ['Dawaki', 'Dandinshe', 'Gargari', 'Jalli', 'Kwa', 'Marke', 'Tattarawa', 'Tofa', 'Tumfafi'],
                'Gwarzo' => ['Gwarzo', 'Getso', 'Jama’a', 'Kara', 'Mainika', 'Modawa', 'Salihawa', 'Unguwar Tudu'],
                'Kabo' => ['Kabo', 'Dugabau', 'Gadiya', 'Garo', 'Kanwa', 'Masana'],
                'Kunchi' => ['Kunchi', 'Bumai', 'Gwarmai', 'Kasallawa', 'Matan Fada', 'Shuwaki'],
                'Makoda' => ['Makoda', 'Babalas', 'Dunawa', 'Jibga', 'Kadandani', 'Koguna', 'Satame'],
                'Minjibir' => ['Minjibir', 'Kantama', 'Kunya', 'Kuru', 'Sarbi', 'Tsuyakpa'],
                'Rimin Gado' => ['Rimin Gado', 'Butu-Butu', 'Dugurawa', 'Gulu', 'Karofin Yashi', 'Tamawa'],
                'Shanono' => ['Shanono', 'Dutsen Bakoshi', 'Faruruwa', 'Goron Dutse', 'Kadamu', 'Shakogi'],
                'Tofa' => ['Tofa', 'Doka', 'Gajida', 'Ginsawa', 'Ja’en', 'Yanshau'],
                'Tsanyawa' => ['Tsanyawa', 'Dumbulum', 'Goza', 'Kachi', 'Tatsan', 'Yankamaye'],

                // Kano South
                'Ajingi' => ['Ajingi', 'Dafin', 'Gafasa', 'Gurduba', 'Kunkurawa', 'Toranke'],
                'Albasu' => ['Albasu', 'Bataiya', 'Chamo', 'Duwan', 'Fanda', 'Hungu'],
                'Bebeji' => ['Bebeji', 'Bagadawa', 'Gwarmai', 'Kofa', 'Ranka', 'Ruan Gaba'],
                'Bunkure' => ['Bunkure', 'Barka', 'Gafam', 'Gora', 'Kumurya', 'Sanda'],
                'Doguwa' => ['Doguwa', 'Dariya', 'Falgore', 'Maraku', 'Natala', 'Tagwaye'],
                'Gaya' => ['Gaya North', 'Gaya South', 'Balau', 'Gamarya', 'Kademi', 'Wudilawa'],
                'Kiru' => ['Kiru', 'Bauda', 'Dangora', 'Kafin Maiyaki', 'Tsaudawa', 'Yako'],
                'Rano' => ['Rano', 'Dawaki', 'Rurum', 'Saji', 'Zurgu'],
                'Rogo' => ['Rogo Ruma', 'Rogo Sabon Gari', 'Beli', 'Falgore', 'Gwan-Gwan', 'Zarewa'],
                'Sumaila' => ['Sumaila', 'Gala', 'Gani', 'Garfa', 'Magami', 'Rimi'],
                'Takai' => ['Takai', 'Bagwaro', 'Durbunde', 'Fajewa', 'Kachako', 'Kunya'],
                'Tudun Wada' => ['Tudun Wada', 'Dalawa', 'Jita', 'Nariya', 'Ruwan Tabo', 'Yarima'],
                'Wudil' => ['Wudil', 'Dagumawa', 'Indabo', 'Kausani', 'Lajawa', 'Utai'],

                // Additional Central LGAs
                'Garun Mallam' => ['Garun Mallam', 'Dorawar Sallau', 'Farin Ruwa', 'Jobawa', 'Kadawa', 'Makadawa', 'Yadwari'],
                'Gezawa' => ['Gezawa', 'Babawa', 'Gawo', 'Gunduwawa', 'Jogana', 'Ketawa', 'Zango'],
                'Kura' => ['Kura', 'Dalili', 'Dan Hassan', 'Dukawa', 'Karfi', 'Kosawa', 'Tofa'],
                'Madobi' => ['Madobi', 'Burum-Burum', 'Chinkoso', 'Gora', 'Kafin Agur', 'Kanwa', 'Kauran Mata'],
                'Warawa' => ['Warawa', 'Gogel', 'Imawa', 'Jamar Da’u', 'Katarkawa', 'Yandalla'],
            ],

            'Zamfara' => [
                'Gusau' => ['Galadima', 'Mada', 'Madawaki', 'Magami', 'Mayana', 'Rijiya', 'Ruwan Bore', 'Sabon Gari', 'Tudun Wada', 'Wanke', 'Wonaka'],
                'Anka' => ['Anka', 'Bagega', 'Barayar-Zaki', 'Dan Galadima', 'Galadima', 'Matseri', 'Sabon Birini', 'Waramu', 'Wuya', 'Yar\'sabaya'],
                'Tsafe' => ['Bilbis', 'Chediya', 'Danjibga', 'Dauki', 'Keta / Kizara', 'Kwaren Ganuwa', 'Tsafe', 'Yan Kuzo', 'Yan Waren Daji'],
                'Talata Mafara' => ['Talata Mafara North', 'Talata Mafara South', 'Jangebe', 'Kaya', 'Kagara', 'Matusgi', 'Shaba', 'Ruwan Gizo'],
                'Kaura Namoda' => ['Bangana', 'Kaura Namoda Gabas', 'Kaura Namoda Yamma', 'Kungurki', 'Kurya', 'Sabaon Gari'],
                'Bungudu' => ['Bungudu', 'Furfuri', 'Gidan Bawa', 'Kwatarkwashi', 'Nahuche', 'Sankalawa', 'Tofa'],
                'Birnin Magaji/Kiyaw' => ['Birnin Magaji', 'Gora', 'Gusami', 'Kiyawa', 'Nassarawo'],
                'Maru' => ['Bingi', 'Dansadau', 'Kanoma', 'Maru', 'Mayanchi', 'Ruwan Doruwa'],
                'Shinkafi' => ['Badarawa', 'Kware', 'Kurya', 'Shinkafi', 'Shanawa'],
                'Zurmi' => ['Dauran', 'Mayasa', 'Zurmi East', 'Zurmi West'],
                'Bakura' => ['Bakura', 'Daki Takwas', 'Nasarawa', 'Rini'],
                'Bukkuyum' => ['Bukkuyum', 'Jangebe', 'Zasuru', 'Nasrawan Burkullu'],
                'Gummi' => ['Gummi', 'Gayari', 'Bardoki', 'Gyallaba'],
                'Maradun' => ['Maradun North', 'Maradun South', 'Faraduchi', 'Kaya', 'Gidan Goga'],
            ]
        ];

        foreach ($data as $stateName => $lgas) {
            foreach ($lgas as $lgaName => $wards) {
                $lga = Lga::where('name', $lgaName)
                    ->whereHas('state', function ($query) use ($stateName) {
                        $query->where('name', $stateName);
                    })->first();

                if ($lga) {
                    foreach ($wards as $wardName) {
                        Ward::updateOrCreate([
                            'name' => $wardName,
                            'state_id' => $lga->state_id,
                            'zone_id' => $lga->zone_id,
                            'lga_id' => $lga->id,
                        ]);
                    }
                }
            }
        }
    }
}
