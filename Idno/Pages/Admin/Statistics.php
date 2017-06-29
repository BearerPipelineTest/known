<?php

namespace Idno\Pages\Admin {

    class Statistics extends \Idno\Common\Page {

        function getContent() {
            $this->adminGatekeeper(); // Admins only
            $tab = $this->getInput('tab');
            
            $stats = \Idno\Core\Statistics::gather($tab);
            
            if (empty($stats) || !is_array($stats))
                throw new \RuntimeException("Something went wrong, either no statistics were returned or it wasn't in the correct format.");

            if ($this->xhr) {

                header('Content-type: application/json');
                
                echo json_encode($stats);
                
            } else {
                $t = \Idno\Core\Idno::site()->template();
                $t->body = $t->__(['statistics' => $stats, 'tab' => $tab])->draw('admin/statistics');
                $t->title = 'Statistics';
                $t->drawPage();
            }
        }

    }

}