<?php
$file = fopen("data.txt", "r");
if (!$file) {
    throw new Exception("Data file not found", 1);
}

$data = [];
while ($row = fgets($file)) {
    $arr = explode("|", $row);
    $data[] = [
        'id' => (int)$arr[0],
        'parent_id' => (int)$arr[1],
        'name' => $arr[2]
    ];
}

function findChildren($data, $parentId) {
    return array_filter($data, function($child) use ($parentId)  {
        return $child['parent_id'] === $parentId;
    });
}

function render($data, $item, $level = 0) {
    for ($i=0; $i<$level ; $i++) { 
        echo "- ";
    }
    echo $item['name'];
    $children = findChildren($data, $item['id']);
    foreach ($children as $child) {
        render($data, $child, $level + 1);
    }
}

foreach ($data as $item) {
    if ($item['parent_id'] === 0) {
        render($data, $item);
    }
}