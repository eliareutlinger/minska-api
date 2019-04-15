

-- -- VIEW 'view_usertoken'
CREATE VIEW view_usertoken AS

SELECT

us.ID AS 'ID',
us.Firstname AS 'Firstname',
us.Lastname AS 'Lastname',
us.Lang AS 'Language',
us.Email AS 'Email',
us.Email_Confirmed AS 'Email_Confirmed',

de.Gender AS 'Gender',
de.Height AS 'Height',
de.Birthdate AS 'Birthdate',
de.Aim_Weight AS 'Aim_Weight',
de.Aim_Date AS 'Aim_Date'

FROM user AS us
LEFT JOIN user_detail AS de ON de.User_ID = us.ID;
