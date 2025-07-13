<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data order_items dan orders sebelum generate dummy baru
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create('id_ID');
        $now = Carbon::now();
        $startDate = $now->copy()->subMonths(3);
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            $createdAt = $faker->dateTimeBetween($startDate, $now);
            $userId = $faker->randomElement($userIds);
            $userName = $faker->name;
            $email = $faker->safeEmail;
            $alamat = $faker->address;
            $telepon = $faker->phoneNumber;
            $status = 'completed';
            $paymentStatus = $faker->randomElement(['unpaid', 'paid']);

            // Buat order dulu tanpa total
            $order = Order::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'email' => $email,
                'alamat' => $alamat,
                'telepon' => $telepon,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'total' => 0,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $total = 0;
            $itemCount = $faker->numberBetween(1, 5);
            $usedProductIds = [];
            for ($j = 0; $j < $itemCount; $j++) {
                $productId = $faker->randomElement(array_diff($productIds, $usedProductIds));
                $usedProductIds[] = $productId;
                $product = Product::find($productId);
                $quantity = $faker->numberBetween(1, 10);
                $price = $product->harga;
                $total += $price * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $product->nama,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
            // Update total order
            $order->update(['total' => $total]);
        }
    }
} 