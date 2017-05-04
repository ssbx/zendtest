<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Description of AlbumTable
 *
 * @author Sébastien Serre <sserre at msha.fr>
 */
class AlbumTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getAlbum($id) {
        $idInt = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $idInt]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                    'Could not find row with identifier %d', $idInt
            ));
        }

        return $row;
    }

    public function saveAlbum(Album $album) {
        $data = [
            'artist' => $album->artist,
            'title' => $album->title,
        ];

        $id = (int) $album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getAlbum($id)) {
            throw new RuntimeException(sprintf(
                    'Cannot update album with identifier %d; does not exist', $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteAlbum($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

}
