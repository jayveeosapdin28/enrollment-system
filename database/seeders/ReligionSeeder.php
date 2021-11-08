<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $religions = [
            'None',
            'Aglipay',
            'Alliance of Bible Christian Communities of the Philippines',
            'Assemblies of God',
            'Association of Baptist Churches in Luzon, Visayas, and Mindanao',
            'Association of Fundamental Baptist Churches in the Philippines',
            'Baptist Conference of the Philippines',
            'Bible Baptist Church',
            'Bread of Life Ministries',
            'Buddhist',
            'Cathedral of Praise, Incorporated',
            'Charismatic Full Gospel Ministries',
            'Christ the Living Stone Fellowship',
            'Christian and Missionary Alliance Church of the Philippines',
            'Christian Missions in the Philippines',
            'Church of Christ',
            'Church of God World Mission in the Philippines',
            'Church of Jesus Christ of the Latter Day Saints',
            'Church of the Nazarene',
            'Christian Reformed Church in the Philippines, Incorporated',
            'Conservative of the Philippine Baptist Church',
            'Convention of the Philippine Baptist Church',
            'Crusaders of the Divine Church of Christ, Incorporated',
            'Door of Faith','Evangelical Christian Outreach Foundation',
            'Evangelical Free Church of the Philippines',
            'Evangelical Presbyterian Church','Faith Tabernacle Church (Living Rock Ministries)',
            'Filipino Assemblies of the First Born, Incorporated',
            'Foursquare Gospel Church in the Philippines',
            'Free Believers in Christ Fellowship',
            'Free Methodist Church',
            'Free Mission in the Philippines, Incorporated',
            'General Baptist Churches of the Philippines',
            'Good News Christian Churches','Higher Ground Baptist Mission',
            'IEMELIF Reform Movement',
            'Iglesia Evangelica Unida de Cristo',
            'Iglesia Evangelista Methodista en Las Islas Filipinas (IEMELIF)',
            'Iglesia Filipina Independiente','Iglesia ni Cristo',
            'Iglesia sa Dios Espiritu Santo, Incorporated',
            'Independent Baptist Churches of the Philippines',
            'Independent Baptist Missionary Fellowship',
            'International One Way Outreach','Islam',"Jehovah's Witness",
            'Jesus Christ Saves Global Outreach',
            'Jesus is Alive Community, Incorporated',
            'Jesus is Lord Church',
            'Jesus Reigns Ministries',
            'Love of Christ International Ministries',
            'Lutheran Church of the Philippines',
            'Miracle Life Fellowship International',
            'Miracle Revival Church of the Philippines',
            'Missionary Baptist Churches of the Philippines',
            'Pentecostal Church of God Asia Mission',
            'Philippine Benevolent Missionaries Association',
            'Philippine Ecumenical Christian Church',
            'Philippine Episcopal Churche',
            'Philippine Evangelical Mission',
            'Philippine General Council of the Assemblies of God',
            'Philippine Good News Ministries',
            'Philippine Grace Gospel',
            'Philippine Independent Catholic Church',
            'Philippine Missionary Fellowship',
            'Philippine Pentecostal Holiness Church',
            "Potter's House Christian Center",
            'Presbyterian Church in the Philippines',
            'Roman Catholic, including Catholic Charismatic',
            'Salvation Army, Philippines',
            'Seventh Day Adventist',
            'Southern Baptist Church',
            'Take the Nation for Jesus Global Ministries (Corpus Christi)',
            'Things to Come',
            'UNIDA Evangelical Church',
            'United Church of Christ in the Philippines',
            'United Evangelical Church of the Philippines (Chinese)',
            'Union Espiritista Cristiana de Filipinas, Incorporated',
            'United Methodists Church','United Pentecostal Church (Philippines), Incorporated',
            'Universal Pentecostal Church',
            'Victory Chapel Christian Fellowship',
            "Watch Tower Bible and Tract Society of the Philippines, Incorporated (Jehovah's Witnesses)",
            'Way of Salvation',
            'Way of Salvation Church Incorporated, The',
            'Wesleyan Church, The',
            'Word for the World',
            'Word International Ministries, Incorporated',
            'World Missionary Evangelism',
            'Worldwide Church of God',
            'Zion Christian Community Church',
            'Other Baptists','Other Evangelical Churches',
            'Other Methodists',
            'Other Protestants',
            'Tribal religions',
            'Other religious affiliations'
        ];

        foreach ($religions as $religion){
            $r = new Religion();
            $r->name = $religion;
            $r->save();
        }
    }
}
