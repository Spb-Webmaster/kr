<?php

namespace App\MoonShine\Controllers;

use App\Models\Order;
use App\Models\OrderPaper;
use App\Models\Product;
use App\Models\ProductPriceOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderPaperCreateController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'count'      => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $product = Product::findOrFail($request->integer('product_id'));
        $count   = $request->integer('count');
        $prices  = $product->prices ?? collect();

        if ($prices->isEmpty()) {
            return $this->createFromSinglePrice($product, $count);
        }

        return $this->createFromPriceOptions($product, $prices, $count);
    }

    private function createFromSinglePrice(Product $product, int $count): JsonResponse
    {
        if (empty($product->price) || (int) $product->price === 0) {
            return response()->json(['message' => 'Не указана цена продукта'], 422);
        }

        for ($i = 0; $i < $count; $i++) {
            OrderPaper::create([
                'number'     => $this->generateUniqueNumber(),
                'product_id' => $product->id,
                'vendor_id'  => $product->vendor_id,
                'price'      => (int) $product->price,
            ]);
        }

        return response()->json(['message' => "Создано {$count} бумажных сертификатов"]);
    }

    private function createFromPriceOptions(Product $product, $prices, int $count): JsonResponse
    {
        $optionTitles = ProductPriceOption::whereIn('id', $prices->pluck('option_id'))
            ->pluck('title', 'id');

        $total = 0;

        foreach ($prices as $priceItem) {
            $optionId    = is_array($priceItem) ? $priceItem['option_id'] : $priceItem->option_id;
            $itemPrice   = is_array($priceItem) ? $priceItem['price'] : $priceItem->price;
            $optionTitle = $optionTitles->get($optionId, '');

            for ($i = 0; $i < $count; $i++) {
                OrderPaper::create([
                    'number'       => $this->generateUniqueNumber(),
                    'product_id'   => $product->id,
                    'vendor_id'    => $product->vendor_id,
                    'price'        => (int) $itemPrice,
                    'price_option' => $optionTitle,
                ]);

                $total++;
            }
        }

        return response()->json(['message' => "Создано {$total} бумажных сертификатов"]);
    }

    private function generateUniqueNumber(): string
    {
        do {
            $number = (string) random_int(10_000_000, 99_999_999);
        } while (
            Order::where('number', $number)->exists() ||
            OrderPaper::where('number', $number)->exists()
        );

        return $number;
    }
}
