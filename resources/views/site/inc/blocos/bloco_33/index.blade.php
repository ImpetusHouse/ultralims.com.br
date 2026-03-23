@if(env('APP_NAME') == 'PróLab')
    <div style="padding-top: {{ $block->margin_top }}px"></div>
@endif
@include('site.inc.breadcrumb', ['breadcrumbs' => generateBreadcrumbs()])
<div style="margin-top: 1px; {!! env('APP_NAME') == 'PróLab' ? 'padding-bottom: '.$block->margin_bottom.'px;':'' !!}"></div>
