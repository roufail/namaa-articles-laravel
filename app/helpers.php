
<?php
if(!function_exists('cleanXSSValue')) {
    function cleanXSSValue($value)
    {
        return str_replace('<script>', '',str_replace('</script>', '', $value));
    }
}   

if(!function_exists('generateSortLink')) {
    function generateSortLink($route, $attribute, $title)
    {
        $route_url = route($route, ['sort_by' => $attribute, 'sort' => request()->get('sort') &&  request()->get('sort') == 'asc' ? 'desc' : 'asc']);
        $icon = (!request()->get('sort') || request()->get('sort') == 'desc')  && request()->get('sort_by') == $attribute ? 'up' : 'down' ;
        $fullIcon = 'fa-sort-'.$icon;
        return "                 
        <span class='sort ml-1'>
             <a href='$route_url'> 
             $title <i class='fa-solid $fullIcon'></i></a>
        </span>";
    }
}   



