<?php

namespace App\Livewire;

trait CanToast {

    public function toast($message, $type='success', $params = [])
    {
        $params = json_encode([
            'type' => $type,
            'duration' => $params['duration'] ?? 3000,
            'dismissible' => $params['dismissable'] ?? true,
            'message' => $message,
            'position' => [
                'x' =>  $params['position']['x'] ?? 'left',
                'y' => $params['position']['y'] ?? 'bottom'
            ]
        ]);

        $this->js("notyf.open($params)");
    }
}