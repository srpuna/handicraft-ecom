<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BlogPost;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Add home page
        $sitemap->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0));

        // Add static pages
        $sitemap->add(Url::create(route('pages.shipping-policy'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.6));

        // Add blog index
        $sitemap->add(Url::create(route('blog.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));

        // Add all blog posts
        BlogPost::where('published', true)
            ->get()
            ->each(function (BlogPost $post) use ($sitemap) {
                $sitemap->add(Url::create(route('blog.show', $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7));
            });

        // Add all products
        Product::where('status', 'active')
            ->get()
            ->each(function (Product $product) use ($sitemap) {
                $sitemap->add(Url::create(route('product.show', $product->slug))
                    ->setLastModificationDate($product->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.9));
            });

        return response($sitemap->toXml(), 200, ['Content-Type' => 'application/xml']);
    }
}
