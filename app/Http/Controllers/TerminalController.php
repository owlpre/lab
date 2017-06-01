<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class TerminalController extends Controller
{
    // var $path = "/var/www/data"; // if using docker
    var $path = "D:/data";

    public function readme() {
        $directory = request()->directory;
        $path = $this->path.$directory;
        $readme = glob($path.'readme.*');
        if (!empty($readme)) {
            $readme = $readme[0];
            $content = file_get_contents($readme);
            if (pathinfo($readme)['extension'] == 'txt') {
                $content = nl2br($content);
            }
            $response = [
                'exists' => true,
                'view' => view('template.readme', [
                    'content' => $content,
                ])->render(),
            ];
        }
        return response()->json(@$response?:false);
    }

    public function ls() {
        $list = @request()->list;
        $onlyDir = @request()->onlyDir;
        $directory = request()->directory;
        $path = $this->path.$directory;
        $items = scandir($path);
        if (!$onlyDir) {
            $items = array_diff($items, ['.', '..']);
        }
        $items = array_values($items);
        $_items = [];
        foreach ($items as $i => $value) {
            $__path = $path.'/'.$value;
            $value = utf8_encode($value);
            $_path = $path.'/'.$value;
            $item = new stdClass;
            $item->name = $value;
            $item->path = $_path;
            $item->pathinfo = pathinfo($_path);
            $item->isDir = is_dir($__path);
            if (!$item->isDir and $onlyDir) {
                continue;
            }
            $_items[] = $item;
        }

        if ($onlyDir or $list) {
            return response()->json([
                'items' => $_items,
            ]);
        }
        $view = view('template.ls', [
            'items' => $_items,
        ])->render();
        return response()->json([
            'view' => $view,
        ]);
    }

    public function index() {
        return view('terminal.index');
    }
}
