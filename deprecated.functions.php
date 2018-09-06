<?php

function cidlookup_add($post){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->add($post);
}

function cidlookup_edit($id, $post){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->edit($id,$post);
}


function cidlookup_did_add($cidlookupid, $extension, $cidnum){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->didAdd($cidlookupid, $extension, $cidnum);
}

function cidlookup_did_del($extension, $cidnum){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->didDelete($extension, $cidnum);
}


function cidlookup_did_list($id = false){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->didList($id);
}

function cidlookup_del($id){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->delete($id);
}

function cidlookup_list($all = false){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->getList($all);
}


function cidlookup_get($id){
    FreePBX::Modules()->deprecatedFunction();
    return FreePBX::Cidlookup()->getOne($id);
}
