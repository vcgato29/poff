
DROP FUNCTION IF EXISTS UserGroupPermissionOnStructure;
DELIMITER |
CREATE FUNCTION UserGroupPermissionOnStructure(curID INT, userGroupID INT) RETURNS INT READS SQL DATA
BEGIN

  	DECLARE curParentID, counter, ugvsPermission,ugvsID INT;
  	SET counter = 0;
  	
  	SELECT id, parentid INTO curID, curParentID FROM structure WHERE id=curID;
  	
  	SELECT  ugvs.permission INTO ugvsPermission  FROM structure s
  		INNER JOIN admin_user_group_vs_structure ugvs ON  ugvs.structure_id = s.id
  		WHERE s.id=curID AND ugvs.admin_user_group_id  = userGroupID;
  		
	while ISNULL(ugvsPermission) AND counter < 10
	do
		SET counter = counter + 1;
	    SELECT id, parentid INTO curID, curParentID FROM structure WHERE id=curParentID;
	    
		SELECT  ugvs.permission INTO ugvsPermission  FROM structure s
			INNER JOIN admin_user_group_vs_structure ugvs ON  ugvs.structure_id = s.id
			WHERE s.id=curID AND ugvs.admin_user_group_id  = userGroupID;

	end while;

RETURN ugvsPermission;
END|

