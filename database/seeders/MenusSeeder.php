<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriByName = KategoriMenu::pluck('id', 'nama_kategori');

        $menusByVendor = [
            'Warung Nusantara' => [
                ['nama_menu' => 'Nasi Rendang Padang', 'kategori' => 'Nasi & Lauk', 'harga' => 26000, 'deskripsi' => 'Nasi hangat dengan rendang sapi empuk dan sambal ijo.', 'path_gambar' => 'https://images.unsplash.com/photo-1604908177522-402f63f4f0f9?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Ayam Bakar Taliwang', 'kategori' => 'Nasi & Lauk', 'harga' => 23000, 'deskripsi' => 'Ayam bakar bumbu taliwang dengan lalapan dan nasi.', 'path_gambar' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Soto Betawi', 'kategori' => 'Mie & Bakso', 'harga' => 22000, 'deskripsi' => 'Soto kuah santan gurih dengan daging dan kentang goreng.', 'path_gambar' => 'https://images.unsplash.com/photo-1626804475297-41608ea09aeb?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Es Cendol Gula Aren', 'kategori' => 'Minuman', 'harga' => 12000, 'deskripsi' => 'Cendol segar dengan santan dan gula aren asli.', 'path_gambar' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Klepon Pandan', 'kategori' => 'Dessert', 'harga' => 9000, 'deskripsi' => 'Klepon lembut isi gula merah, tabur kelapa parut.', 'path_gambar' => 'https://images.unsplash.com/photo-1541783245831-57d6fb0926d3?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'The Burger Hub' => [
                ['nama_menu' => 'Classic Beef Burger', 'kategori' => 'Camilan', 'harga' => 32000, 'deskripsi' => 'Burger daging sapi juicy dengan keju dan saus signature.', 'path_gambar' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Chicken Cheese Burger', 'kategori' => 'Camilan', 'harga' => 29000, 'deskripsi' => 'Patty ayam crispy, cheddar, dan mayo garlic.', 'path_gambar' => 'https://images.unsplash.com/photo-1615297928064-24977384d0da?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Curly Fries BBQ', 'kategori' => 'Camilan', 'harga' => 18000, 'deskripsi' => 'Kentang goreng spiral dengan bumbu BBQ smoky.', 'path_gambar' => 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Iced Lemon Tea', 'kategori' => 'Minuman', 'harga' => 12000, 'deskripsi' => 'Teh lemon dingin segar untuk teman burger.', 'path_gambar' => 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Choco Sundae', 'kategori' => 'Dessert', 'harga' => 15000, 'deskripsi' => 'Es krim vanila dengan saus cokelat dan crumble.', 'path_gambar' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Bubble Tea Corner' => [
                ['nama_menu' => 'Brown Sugar Boba Milk', 'kategori' => 'Minuman', 'harga' => 24000, 'deskripsi' => 'Susu segar dengan brown sugar syrup dan boba chewy.', 'path_gambar' => 'https://images.unsplash.com/photo-1558857563-b371033873b8?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Thai Tea Boba', 'kategori' => 'Minuman', 'harga' => 22000, 'deskripsi' => 'Thai tea creamy dengan topping boba hitam.', 'path_gambar' => 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Matcha Latte Boba', 'kategori' => 'Minuman', 'harga' => 25000, 'deskripsi' => 'Matcha latte premium dengan boba dan foam lembut.', 'path_gambar' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Mango Yakult', 'kategori' => 'Minuman', 'harga' => 21000, 'deskripsi' => 'Perpaduan mangga manis dan yakult menyegarkan.', 'path_gambar' => 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Taro Milk Pudding', 'kategori' => 'Dessert', 'harga' => 18000, 'deskripsi' => 'Pudding taro lembut dengan susu dingin.', 'path_gambar' => 'https://images.unsplash.com/photo-1464306076886-da185f6a9d05?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Ramen Station' => [
                ['nama_menu' => 'Shoyu Chicken Ramen', 'kategori' => 'Mie & Bakso', 'harga' => 32000, 'deskripsi' => 'Ramen kuah shoyu dengan ayam chashu dan telur.', 'path_gambar' => 'https://images.unsplash.com/photo-1557872943-16a5ac26437e?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Spicy Miso Ramen', 'kategori' => 'Mie & Bakso', 'harga' => 34000, 'deskripsi' => 'Ramen miso pedas dengan irisan ayam dan nori.', 'path_gambar' => 'https://images.unsplash.com/photo-1623341214825-9f4f963727da?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Gyoza Crispy', 'kategori' => 'Camilan', 'harga' => 18000, 'deskripsi' => 'Gyoza goreng renyah isi ayam dan sayur.', 'path_gambar' => 'https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Ocha Dingin', 'kategori' => 'Minuman', 'harga' => 9000, 'deskripsi' => 'Teh hijau dingin tanpa gula, ringan dan segar.', 'path_gambar' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Mochi Ice Cream', 'kategori' => 'Dessert', 'harga' => 16000, 'deskripsi' => 'Mochi kenyal isi es krim vanila dingin.', 'path_gambar' => 'https://images.unsplash.com/photo-1582248478054-3f31a0f5f4d6?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Fresh & Healthy' => [
                ['nama_menu' => 'Chicken Caesar Salad', 'kategori' => 'Nasi & Lauk', 'harga' => 26000, 'deskripsi' => 'Salad romaine segar dengan ayam panggang dan dressing caesar.', 'path_gambar' => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Grain Bowl Tempe', 'kategori' => 'Nasi & Lauk', 'harga' => 24000, 'deskripsi' => 'Bowl quinoa, tempe panggang, jagung, dan sayur segar.', 'path_gambar' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Edamame Sea Salt', 'kategori' => 'Camilan', 'harga' => 14000, 'deskripsi' => 'Edamame rebus dengan taburan sea salt.', 'path_gambar' => 'https://images.unsplash.com/photo-1604908177453-7462950a6a3b?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Infused Lemon Water', 'kategori' => 'Minuman', 'harga' => 10000, 'deskripsi' => 'Air mineral dengan lemon dan mint segar.', 'path_gambar' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Greek Yogurt Parfait', 'kategori' => 'Dessert', 'harga' => 18000, 'deskripsi' => 'Yogurt, granola, dan buah segar dalam satu cup.', 'path_gambar' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Campus Brew' => [
                ['nama_menu' => 'Americano Ice', 'kategori' => 'Minuman', 'harga' => 18000, 'deskripsi' => 'Kopi hitam dingin dengan espresso single origin.', 'path_gambar' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Caramel Latte', 'kategori' => 'Minuman', 'harga' => 24000, 'deskripsi' => 'Latte creamy dengan sentuhan karamel manis.', 'path_gambar' => 'https://images.unsplash.com/photo-1497935586047-9398b2b2a6b4?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Matcha Espresso Fusion', 'kategori' => 'Minuman', 'harga' => 27000, 'deskripsi' => 'Perpaduan matcha premium dan espresso.', 'path_gambar' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Croissant Butter', 'kategori' => 'Camilan', 'harga' => 16000, 'deskripsi' => 'Croissant flaky dengan aroma butter hangat.', 'path_gambar' => 'https://images.unsplash.com/photo-1555507036-ab794f4afe5a?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Chocolate Muffin', 'kategori' => 'Dessert', 'harga' => 17000, 'deskripsi' => 'Muffin cokelat lembut dengan choco chips.', 'path_gambar' => 'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Warung Bu Sari' => [
                ['nama_menu' => 'Nasi Gudeg Ayam', 'kategori' => 'Nasi & Lauk', 'harga' => 18000, 'deskripsi' => 'Gudeg nangka manis khas Jawa dengan ayam kampung yang empuk.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/b4868082f44d5fcae80353e16c295d3433235867?width=572', 'is_available' => true],
                ['nama_menu' => 'Mie Ayam Special', 'kategori' => 'Mie & Bakso', 'harga' => 15000, 'deskripsi' => 'Mie segar dengan ayam bumbu, sayuran, dan kuah kaldu gurih.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/e8073bad16f9206f6db4ed97a46992857a06c541?width=572', 'is_available' => true],
                ['nama_menu' => 'Gado-Gado', 'kategori' => 'Nasi & Lauk', 'harga' => 12000, 'deskripsi' => 'Sayuran segar campur dengan saus kacang kental dan kerupuk.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/90cd24b470a76a19da724907cb7eb0904ad6b86c?width=572', 'is_available' => true],
                ['nama_menu' => 'Sate Ayam', 'kategori' => 'Camilan', 'harga' => 20000, 'deskripsi' => 'Sate ayam bakar dengan saus kacang pedas dan lontong.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/a9bee7f0eaa15b4f21efae9546c2163920d61992?width=572', 'is_available' => true],
                ['nama_menu' => 'Es Teh Manis', 'kategori' => 'Minuman', 'harga' => 5000, 'deskripsi' => 'Teh manis dingin yang menyegarkan, cocok teman makan.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/f54094bf7f4c4ebb7a73256c88f3d3e0bb240384?width=572', 'is_available' => true],
                ['nama_menu' => 'Bakso Special', 'kategori' => 'Mie & Bakso', 'harga' => 16000, 'deskripsi' => 'Bakso sapi jumbo dengan mie, sayuran segar, dan kuah kaldu.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572', 'is_available' => true],
                ['nama_menu' => 'Pisang Goreng', 'kategori' => 'Camilan', 'harga' => 8000, 'deskripsi' => 'Pisang goreng renyah, camilan manis yang sempurna.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/652fb0b468b9036c588a47020389155a651a3a58?width=572', 'is_available' => true],
                ['nama_menu' => 'Es Jeruk Segar', 'kategori' => 'Minuman', 'harga' => 8000, 'deskripsi' => 'Jus jeruk peras segar dengan es batu, kaya vitamin.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572', 'is_available' => true],
                ['nama_menu' => 'Nasi Rawon Surabaya', 'kategori' => 'Nasi & Lauk', 'harga' => 21000, 'deskripsi' => 'Rawon daging hitam khas Surabaya dengan sambal tauge.', 'path_gambar' => 'https://images.unsplash.com/photo-1604908811889-c1ffb7fa4ef8?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Es Campur Spesial', 'kategori' => 'Dessert', 'harga' => 13000, 'deskripsi' => 'Es campur buah, cincau, dan sirup segar.', 'path_gambar' => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b4?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
            'Warung Mbok Sri' => [
                ['nama_menu' => 'Nasi Goreng Spesial', 'kategori' => 'Nasi & Lauk', 'harga' => 18000, 'deskripsi' => 'Nasi goreng dengan telur mata sapi, ayam, dan bumbu rahasia khas warung.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/ba6382dc578b32751a4c6e03f2066fc64f93e8ce?width=504', 'is_available' => true],
                ['nama_menu' => 'Bakso Kuah Spesial', 'kategori' => 'Mie & Bakso', 'harga' => 15000, 'deskripsi' => 'Bakso sapi dengan mie, sayuran segar, dan kuah kaldu yang gurih.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/3c5c09db60a4a2b7edf59cf09759e90f728ef682?width=504', 'is_available' => true],
                ['nama_menu' => 'Soto Ayam Lamongan', 'kategori' => 'Nasi & Lauk', 'harga' => 12000, 'deskripsi' => 'Soto ayam kuning dengan telur, soun, dan sayuran segar berkuah bening.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/b7bc82529c259c8ada923ec2170e09044304699d?width=504', 'is_available' => true],
                ['nama_menu' => 'Es Teh Manis', 'kategori' => 'Minuman', 'harga' => 5000, 'deskripsi' => 'Teh manis dingin dengan es batu, kesegaran di hari yang panas.', 'path_gambar' => 'https://api.builder.io/api/v1/image/assets/TEMP/51abe326054c31ac42ba035e0234a59fd2ae076e?width=504', 'is_available' => true],
                ['nama_menu' => 'Nasi Ayam Geprek', 'kategori' => 'Nasi & Lauk', 'harga' => 17000, 'deskripsi' => 'Ayam crispy geprek sambal bawang dengan nasi hangat.', 'path_gambar' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Mie Goreng Jawa', 'kategori' => 'Mie & Bakso', 'harga' => 15000, 'deskripsi' => 'Mie goreng bumbu tradisional dengan topping ayam dan telur.', 'path_gambar' => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Tahu Isi Krispi', 'kategori' => 'Camilan', 'harga' => 9000, 'deskripsi' => 'Tahu isi sayur digoreng garing, cocok untuk teman minum.', 'path_gambar' => 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Es Jeruk Segar', 'kategori' => 'Minuman', 'harga' => 8000, 'deskripsi' => 'Es jeruk asli dengan rasa manis-asam yang seimbang.', 'path_gambar' => 'https://images.unsplash.com/photo-1610970881699-44a5587cabec?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
                ['nama_menu' => 'Puding Cokelat', 'kategori' => 'Dessert', 'harga' => 10000, 'deskripsi' => 'Puding cokelat lembut dengan saus vanilla.', 'path_gambar' => 'https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?w=900&q=80&auto=format&fit=crop', 'is_available' => true],
            ],
        ];

        foreach ($menusByVendor as $vendorName => $menus) {
            $vendor = Vendor::where('nama_vendor', $vendorName)->first();

            if (! $vendor) {
                continue;
            }

            foreach ($menus as $menu) {
                Menu::updateOrCreate(
                    [
                        'vendor_id' => $vendor->id,
                        'nama_menu' => $menu['nama_menu'],
                    ],
                    [
                        'kategori_menu_id' => $kategoriByName[$menu['kategori']] ?? null,
                        'deskripsi' => $menu['deskripsi'],
                        'harga' => $menu['harga'],
                        'path_gambar' => $menu['path_gambar'] ?? null,
                        'is_available' => $menu['is_available'] ?? true,
                    ]
                );
            }
        }
    }
}
