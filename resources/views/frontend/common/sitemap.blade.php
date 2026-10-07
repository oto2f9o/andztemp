<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>{{ route('home') }}</loc>
		<lastmod>{{ date(DATE_ATOM) }}</lastmod>
        <priority>1.0</priority>
	</url>
    @foreach($pages as $page)
    @if($page->parent_id)
	<url>
		<loc>{{ route('page', ['slug' => $page->parent()->slug, 'inner' => $page->slug]) }}</loc>
		<lastmod>{{ $page->updated_at->format('Y-m-d\TH:i:s.uP') }}</lastmod>
        <priority>0.9</priority>
	</url>
    @else
	<url>
		<loc>{{ route('page', $page->slug) }}</loc>
		<lastmod>{{ $page->updated_at->format('Y-m-d\TH:i:s.uP') }}</lastmod>
        <priority>0.9</priority>
	</url>
    @endif
    @endforeach
</urlset>