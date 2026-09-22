<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\ClientNote;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PettyCash;
use App\Models\WorkShift;
use App\Models\Complaint;
use App\Models\SystemLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('system_logs')->delete();
        DB::table('complaints')->delete();
        DB::table('work_shifts')->delete();
        DB::table('petty_cashes')->delete();
        DB::table('transaction_items')->delete();
        DB::table('transactions')->delete();
        DB::table('client_notes')->delete();
        DB::table('reviews')->delete();
        DB::table('portfolios')->delete();
        DB::table('vouchers')->delete();
        DB::table('products')->delete();
        DB::table('services')->delete();
        DB::table('bookings')->delete();
        User::query()->delete();

        // 1. Users
        $usersData = [
            [
                'name' => 'Owner District',
                'email' => 'owner@district.com',
                'password' => bcrypt('123'),
                'role' => 'owner',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Admin District',
                'email' => 'admin@district.com',
                'password' => bcrypt('123'),
                'security_pin' => bcrypt('123456'),
                'role' => 'admin',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Kasir District',
                'email' => 'kasir@district.com',
                'password' => bcrypt('123'),
                'role' => 'kasir',
                'phone' => '081234567892',
            ],
            [
                'name' => 'veng',
                'email' => 'veng@district.com',
                'password' => bcrypt('123'),
                'role' => 'hair stylist',
                'phone' => '081234567893',
                'work_status' => 'Available',
                'commission_rate' => 30,
            ],
            [
                'name' => 'Gallagher',
                'email' => 'gallagher@district.com',
                'password' => bcrypt('123'),
                'role' => 'hair stylist',
                'phone' => '081234567894',
                'work_status' => 'On Duty',
                'commission_rate' => 35,
            ],
            [
                'name' => 'Pelupessy',
                'email' => 'pelupessy@district.com',
                'password' => bcrypt('123'),
                'role' => 'hair stylist',
                'phone' => '081234567895',
                'work_status' => 'Break',
                'commission_rate' => 30,
            ],
            [
                'name' => 'Supervisor District',
                'email' => 'supervisor@district.com',
                'password' => bcrypt('123'),
                'role' => 'supervisor',
                'phone' => '081234567897',
            ],
            [
                'name' => 'Receptionist District',
                'email' => 'receptionist@district.com',
                'password' => bcrypt('123'),
                'role' => 'receptionist',
                'phone' => '081234567898',
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@district.com',
                'password' => bcrypt('123'),
                'role' => 'customer',
                'phone' => '081234567896',
            ],
            [
                'name' => 'Randi Budi',
                'email' => 'randi@gmail.com',
                'password' => bcrypt('123'),
                'role' => 'customer',
                'phone' => '081987654321',
            ],
        ];

        foreach ($usersData as $u) {
            $u['email_verified_at'] = now();
            User::create($u);
        }

        $cust = User::where('role', 'customer')->first();
        $randi = User::where('email', 'randi@gmail.com')->first();
        $veng = User::where('email', 'veng@district.com')->first();
        $gallagher = User::where('email', 'gallagher@district.com')->first();
        $pelupessy = User::where('email', 'pelupessy@district.com')->first();
        $kasir = User::where('role', 'kasir')->first();
        $receptionist = User::where('role', 'receptionist')->first();

        // 2. Services
        // 2. Services (Harga Terjangkau Rp 50.000 - Rp 200.000)
        $services = [
            ['name' => 'Junior Stylist Haircut & Wash', 'category' => 'Haircut', 'price' => 50000, 'duration_minutes' => 30, 'description' => 'Cuci rambut, haircut presisi & penataan ringan oleh Junior Stylist.'],
            ['name' => 'Executive Beard Trim & Hot Towel', 'category' => 'Beard & Shave', 'price' => 60000, 'duration_minutes' => 30, 'description' => 'Cukur kumis & jenggot rapi dengan treatment handuk hangat.'],
            ['name' => 'Gentleman Haircut & Wash', 'category' => 'Haircut', 'price' => 75000, 'duration_minutes' => 45, 'description' => 'Cuci rambut, haircut presisi, pijat kepala ringan & hair styling.'],
            ['name' => 'Senior Stylist Haircut & Wash', 'category' => 'Haircut', 'price' => 90000, 'duration_minutes' => 45, 'description' => 'Potongan rambut custom oleh penata rambut berpengalaman.'],
            ['name' => 'Hair Spa & Creambath Premium', 'category' => 'Hair Care', 'price' => 85000, 'duration_minutes' => 45, 'description' => 'Pijat kulit kepala relaksasi & masker vitamin rambut bernutrisi.'],
            ['name' => 'Art Director Cut & Styling', 'category' => 'Haircut', 'price' => 120000, 'duration_minutes' => 60, 'description' => 'Potong rambut khusus oleh Art Director master kapster.'],
            ['name' => 'Volume / Root Lift Perm', 'category' => 'Styling', 'price' => 150000, 'duration_minutes' => 75, 'description' => 'Menambah volume dan tekstur bergelombang alami pada rambut.'],
            ['name' => 'Down Perm & Hair Treatment', 'category' => 'Styling', 'price' => 175000, 'duration_minutes' => 90, 'description' => 'Treatment merapikan rambut samping yang mengembang.'],
            ['name' => 'Fashion Hair Coloring', 'category' => 'Coloring', 'price' => 200000, 'duration_minutes' => 120, 'description' => 'Pewarnaan rambut trendi premium tanpa merusak kulit kepala.'],
        ];
        foreach ($services as $s) {
            Service::create($s);
        }

        // 3. Products (Harga Terjangkau Rp 50.000 - Rp 85.000)
        $products = [
            ['name' => 'Premium Hair Tonic Menthol 150ml', 'category' => 'Hair Care', 'price' => 50000, 'stock' => 20, 'min_stock' => 3, 'description' => 'Menguatkan akar rambut dan sensasi dingin menyegarkan.'],
            ['name' => 'District Styling Hair Powder 20g', 'category' => 'Hair Powder', 'price' => 65000, 'stock' => 18, 'min_stock' => 5, 'description' => 'Menambah volume rambut seketika tanpa lengket.'],
            ['name' => 'Nourishing Beard & Mustache Oil 30ml', 'category' => 'Beard Care', 'price' => 75000, 'stock' => 10, 'min_stock' => 2, 'description' => 'Minyak perawatan jenggot dan kumis agar halus dan harum.'],
            ['name' => 'District Matte Clay Pomade 100g', 'category' => 'Pomade', 'price' => 85000, 'stock' => 24, 'min_stock' => 5, 'description' => 'Hold kuat, hasil natural matte finish tidak berkilau.'],
        ];
        foreach ($products as $p) {
            Product::create($p);
        }

        // 4. Vouchers
        Voucher::create(['code' => 'PROMO20', 'type' => 'percent', 'discount_value' => 20, 'min_spend' => 50000, 'valid_until' => '2026-12-31', 'is_active' => true]);
        Voucher::create(['code' => 'BARBER25K', 'type' => 'fixed', 'discount_value' => 25000, 'min_spend' => 75000, 'valid_until' => '2026-12-31', 'is_active' => true]);

        // 5. Portfolios
        if ($veng) {
            Portfolio::create(['stylist_id' => $veng->id, 'title' => 'Modern Fade & Textured Quiff', 'image_path' => '/images/portfolios/veng_1.jpg', 'description' => 'Fade samping 0.5mm dengan tekstur atas acak natural.']);
            Portfolio::create(['stylist_id' => $veng->id, 'title' => 'Korean Two Block Cut', 'image_path' => '/images/portfolios/veng_2.jpg', 'description' => 'Gaya rambut K-pop dengan down perm samping.']);
        }
        if ($gallagher) {
            Portfolio::create(['stylist_id' => $gallagher->id, 'title' => 'Classic Slick Back Undercut', 'image_path' => '/images/portfolios/gallagher_1.jpg', 'description' => 'Gaya klimis klasik ala pemuda gentlemans.']);
            Portfolio::create(['stylist_id' => $gallagher->id, 'title' => 'French Crop Fade', 'image_path' => '/images/portfolios/gallagher_2.jpg', 'description' => 'French crop dengan skin fade bersih dan rapi.']);
        }
        if ($pelupessy) {
            Portfolio::create(['stylist_id' => $pelupessy->id, 'title' => 'Disconnected Undercut', 'image_path' => '/images/portfolios/pelupessy_1.jpg', 'description' => 'Undercut tegas dengan tekstur atas yang modern.']);
            Portfolio::create(['stylist_id' => $pelupessy->id, 'title' => 'Curly Top High Fade', 'image_path' => '/images/portfolios/pelupessy_2.jpg', 'description' => 'Perpaduan curly natural dengan high fade yang kontras.']);
        }

        // 6. Reviews & Ratings
        if ($cust && $veng) {
            Review::create(['customer_id' => $cust->id, 'stylist_id' => $veng->id, 'rating' => 5, 'comment' => 'Hasil pengerjaan mas Veng sangat rapi dan teliti! Fade samping halus sekali.']);
        }
        if ($randi && $gallagher) {
            Review::create(['customer_id' => $randi->id, 'stylist_id' => $gallagher->id, 'rating' => 5, 'comment' => 'Potongan Gallagher mantap, stylingnya tahan lama seharian.']);
        }

        // 7. Client Notes
        if ($cust && $veng) {
            ClientNote::create(['customer_id' => $cust->id, 'stylist_id' => $veng->id, 'notes' => 'Samping fade 1mm tinggi, bagian atas potong tipis 1cm saja, belah samping kiri. Rambut agak kaku.']);
        }

        // 8. Bookings & Live Queue
        $today = date('Y-m-d');
        if ($cust && $veng) {
            Booking::create([
                'user_id' => $cust->id,
                'branch' => 'Jakarta Kebayoran Baru',
                'service' => 'Gentleman Haircut & Wash (IDR 75.000)',
                'booking_date' => $today,
                'booking_time' => '10:00',
                'status' => 'approved',
                'stylist_id' => $veng->id,
                'queue_number' => 'A-001',
                'type' => 'online',
                'arrived_at' => now(),
                'price' => 75000,
            ]);
        }

        $b2 = null;
        if ($randi && $gallagher) {
            $b2 = Booking::create([
                'user_id' => $randi->id,
                'branch' => 'Jakarta Kebayoran Baru',
                'service' => 'Art Director Cut & Styling (IDR 120.000)',
                'booking_date' => $today,
                'booking_time' => '11:30',
                'status' => 'completed',
                'stylist_id' => $gallagher->id,
                'queue_number' => 'A-002',
                'type' => 'online',
                'arrived_at' => now()->subHours(1),
                'price' => 120000,
            ]);
        }

        if ($cust && $pelupessy) {
            Booking::create([
                'user_id' => $cust->id,
                'branch' => 'Bandung Citarum',
                'service' => 'Down Perm & Hair Treatment (IDR 175.000)',
                'booking_date' => $today,
                'booking_time' => '14:00',
                'status' => 'pending',
                'stylist_id' => $pelupessy->id,
                'queue_number' => 'B-001',
                'type' => 'walkin',
                'price' => 175000,
            ]);
        }

        // 9. Petty Cash
        if ($kasir) {
            PettyCash::create(['cashier_id' => $kasir->id, 'amount' => 35000, 'category' => 'Perlengkapan', 'description' => 'Beli es batu & tisu gulung ruang tunggu', 'expense_date' => $today]);
            PettyCash::create(['cashier_id' => $kasir->id, 'amount' => 50000, 'category' => 'Kebersihan', 'description' => 'Cairan pembersih lantai & pisau cukur sterilizer', 'expense_date' => $today]);
        }

        // 10. Work Shifts
        if ($veng) WorkShift::create(['user_id' => $veng->id, 'shift_date' => $today, 'shift_type' => 'Pagi', 'notes' => 'Shift 09:00 - 17:00']);
        if ($gallagher) WorkShift::create(['user_id' => $gallagher->id, 'shift_date' => $today, 'shift_type' => 'Siang', 'notes' => 'Shift 13:00 - 21:00']);
        if ($kasir) WorkShift::create(['user_id' => $kasir->id, 'shift_date' => $today, 'shift_type' => 'Full', 'notes' => 'Shift Full Day']);

        // 11. Complaints
        if ($cust) {
            Complaint::create(['customer_id' => $cust->id, 'customer_name' => $cust->name, 'category' => 'Fasilitas', 'message' => 'AC di area tunggu cabang Kebayoran Baru agak kurang dingin saat jam 13:00.', 'status' => 'in_progress', 'resolution' => 'Tim teknisi sedang dijadwalkan untuk service AC.']);
        }

        // 12. Transactions & Items Seed
        if ($kasir && $cust && $randi) {
            $yesterdayDate = \Carbon\Carbon::yesterday();
            $twoDaysAgo    = \Carbon\Carbon::today()->subDays(2);
            $threeDaysAgo  = \Carbon\Carbon::today()->subDays(3);

            // Trx 1: 3 days ago - Cash
            $t1 = Transaction::create([
                'booking_id'      => null,
                'cashier_id'      => $kasir->id,
                'customer_id'     => $cust->id,
                'customer_name'   => $cust->name,
                'subtotal'        => 75000,
                'discount_amount' => 0,
                'final_amount'    => 75000,
                'payment_method'  => 'Cash',
                'payment_status'  => 'paid',
                'created_at'      => $threeDaysAgo->copy()->setTime(11, 15),
                'updated_at'      => $threeDaysAgo->copy()->setTime(11, 15),
            ]);
            TransactionItem::create([
                'transaction_id' => $t1->id,
                'item_type'      => 'service',
                'item_id'        => 3,
                'item_name'      => 'Gentleman Haircut & Wash',
                'price'          => 75000,
                'quantity'       => 1,
                'subtotal'       => 75000,
                'created_at'     => $t1->created_at,
                'updated_at'     => $t1->updated_at,
            ]);

            // Trx 2: 2 days ago - QRIS
            $t2 = Transaction::create([
                'booking_id'      => null,
                'cashier_id'      => $kasir->id,
                'customer_id'     => $randi->id,
                'customer_name'   => $randi->name,
                'subtotal'        => 175000,
                'discount_amount' => 25000,
                'final_amount'    => 150000,
                'payment_method'  => 'QRIS',
                'payment_status'  => 'paid',
                'created_at'      => $twoDaysAgo->copy()->setTime(14, 30),
                'updated_at'      => $twoDaysAgo->copy()->setTime(14, 30),
            ]);
            TransactionItem::create([
                'transaction_id' => $t2->id,
                'item_type'      => 'service',
                'item_id'        => 8,
                'item_name'      => 'Down Perm & Hair Treatment',
                'price'          => 175000,
                'quantity'       => 1,
                'subtotal'       => 175000,
                'created_at'     => $t2->created_at,
                'updated_at'     => $t2->updated_at,
            ]);

            // Trx 3: Yesterday - Cash
            $t3 = Transaction::create([
                'booking_id'      => null,
                'cashier_id'      => $kasir->id,
                'customer_id'     => $cust->id,
                'customer_name'   => 'Dimas Anggara',
                'subtotal'        => 135000,
                'discount_amount' => 0,
                'final_amount'    => 135000,
                'payment_method'  => 'Cash',
                'payment_status'  => 'paid',
                'created_at'      => $yesterdayDate->copy()->setTime(16, 0),
                'updated_at'      => $yesterdayDate->copy()->setTime(16, 0),
            ]);
            TransactionItem::create([
                'transaction_id' => $t3->id,
                'item_type'      => 'service',
                'item_id'        => 1,
                'item_name'      => 'Junior Stylist Haircut & Wash',
                'price'          => 50000,
                'quantity'       => 1,
                'subtotal'       => 50000,
                'created_at'     => $t3->created_at,
                'updated_at'     => $t3->updated_at,
            ]);
            TransactionItem::create([
                'transaction_id' => $t3->id,
                'item_type'      => 'product',
                'item_id'        => 4,
                'item_name'      => 'District Matte Clay Pomade 100g',
                'price'          => 85000,
                'quantity'       => 1,
                'subtotal'       => 85000,
                'created_at'     => $t3->created_at,
                'updated_at'     => $t3->updated_at,
            ]);

            // Trx 4: Today - Cash
            $t4 = Transaction::create([
                'booking_id'      => null,
                'cashier_id'      => $kasir->id,
                'customer_id'     => null,
                'customer_name'   => 'Budi Setiawan',
                'subtotal'        => 75000,
                'discount_amount' => 0,
                'final_amount'    => 75000,
                'payment_method'  => 'Cash',
                'payment_status'  => 'paid',
                'created_at'      => \Carbon\Carbon::today()->setTime(9, 30),
                'updated_at'      => \Carbon\Carbon::today()->setTime(9, 30),
            ]);
            TransactionItem::create([
                'transaction_id' => $t4->id,
                'item_type'      => 'service',
                'item_id'        => 3,
                'item_name'      => 'Gentleman Haircut & Wash',
                'price'          => 75000,
                'quantity'       => 1,
                'subtotal'       => 75000,
                'created_at'     => $t4->created_at,
                'updated_at'     => $t4->updated_at,
            ]);

            // Trx 5: Today - QRIS
            $t5 = Transaction::create([
                'booking_id'      => $b2 ? $b2->id : null,
                'cashier_id'      => $kasir->id,
                'customer_id'     => $randi->id,
                'customer_name'   => $randi->name,
                'subtotal'        => 120000,
                'discount_amount' => 0,
                'final_amount'    => 120000,
                'payment_method'  => 'QRIS',
                'payment_status'  => 'paid',
                'created_at'      => \Carbon\Carbon::today()->setTime(12, 0),
                'updated_at'      => \Carbon\Carbon::today()->setTime(12, 0),
            ]);
            TransactionItem::create([
                'transaction_id' => $t5->id,
                'item_type'      => 'service',
                'item_id'        => 6,
                'item_name'      => 'Art Director Cut & Styling',
                'price'          => 120000,
                'quantity'       => 1,
                'subtotal'       => 120000,
                'created_at'     => $t5->created_at,
                'updated_at'     => $t5->updated_at,
            ]);
        }

        // 13. System Logs
        if ($kasir) {
            SystemLog::create(['user_id' => $kasir->id, 'action' => 'POS Checkout', 'details' => 'Proses pembayaran transaksi #POS-1001 sebesar Rp 180.000 via QRIS', 'ip_address' => '127.0.0.1']);
        }
    }
}
