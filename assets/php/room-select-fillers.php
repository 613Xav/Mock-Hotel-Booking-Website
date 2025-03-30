<?php

require_once "database.php";

//main SQL

function getRooms() {
    global $db; 
    $sql = "SELECT room_id, prix, capacite, vue_mer, vue_montagne, extensible, dommage FROM chambre";
    $stmt = $db->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getHotelChains (){
    global $db;
    $sql = "SELECT chain_id, nom FROM chainehoteliere";
    $stmt = $db->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getHotels($chainId){
    global $db;
    $sql = "SELECT hotel_id, adresse FROM hotel WHERE chain_id = :chainId";
    $stmt = $db->prepare($sql);
    $stmt->execute([':chainId' => $chainId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

function getRoomsByHotel($hotelId) {
    global $db;
    $sql = "SELECT room_id, prix, capacite, vue_mer, vue_montagne, extensible FROM chambre WHERE hotel_id = :hotelId";
    $stmt = $db->prepare($sql);
    $stmt->execute(['hotelId' => $hotelId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





















?>