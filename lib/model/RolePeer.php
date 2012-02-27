<?php

class RolePeer extends BaseRolePeer
{
	public static function checkPermission($role_id, $permission_id){
		$c = new Criteria();
		$c->add(RolePermissionPeer::PERMISSION_ID, $permission_id);
		$c->add(RolePermissionPeer::ROLE_ID, $role_id);
		$rolePermission = RolePermissionPeer::doSelectOne($c);
		
		if($rolePermission){
			return true;
		} else {
			return false;
		}
	}
}
