<?php
/*********************************************************************
    staff.php

    Evertything about staff members.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('admin.inc.php');

// Included here for role permission registration
require_once INCLUDE_DIR . 'class.report.php';

$staff=null;
if($_REQUEST['id'] && !($staff=Staff::lookup($_REQUEST['id'])))
    $errors['err']=sprintf(__('%s: Unknown or invalid ID.'), __('agent'));

if($_POST){
    switch(strtolower($_POST['do'])){
        case 'update':
            if(!$staff){
                $errors['err']=sprintf(__('%s: Unknown or invalid'), __('agent'));
            }elseif($staff->update($_POST,$errors)){

                $sql = "UPDATE osticket.ost_user SET name = '".$_POST['firstname']." ".$_POST['lastname']."', updated = NOW() WHERE id = '".$staff->getstaffuserId()."'";
                $query = db_query($sql);
                $sql2 = "UPDATE osticket.ost_user_email SET address = '".$_POST['email']."' WHERE user_id = '".$staff->getstaffuserId()."'";
                $query2 = db_query($sql2);
                $sql3 = "UPDATE osticket.ost_user__cdata SET phone = '".$_POST['phone']."', notes = '".$_POST['notes']."' WHERE user_id = '".$staff->getstaffuserId()."'";
                $query3 = db_query($sql3);

                $msg=sprintf(__('Successfully updated %s.'),
                    __('this agent'));
            }elseif(!$errors['err']){
                $errors['err']=sprintf('%s %s',
                    sprintf(__('Unable to update %s.'), __('this agent')),
                    __('Correct any errors below and try again.'));
            }
            break;
        case 'create':
            $staff = Staff::create();
            // Unpack the data from the set-password dialog (if used)
            if (isset($_SESSION['new-agent-passwd'])) {
                foreach ($_SESSION['new-agent-passwd'] as $k=>$v)
                    if (!isset($_POST[$k]))
                        $_POST[$k] = $v;
            }
            if ($staff->update($_POST,$errors)) {

                $sql = "INSERT INTO osticket.ost_user ( org_id, status, name, reply, created, updated ) VALUES ( '0', '0', '".$_POST['firstname']." ".$_POST['lastname']."', '0', NOW(), NOW() )";
                $query = db_query($sql);
                $sql2 = "INSERT INTO osticket.ost_user_email ( user_id, flags, address ) VALUES ( (SELECT id FROM osticket.ost_user WHERE name = '".$_POST['firstname']." ".$_POST['lastname']."'), '0', '".$_POST['email']."' )";
                $query2 = db_query($sql2);
                $sql3 = "INSERT INTO osticket.ost_user__cdata (user_id, phone, notes) VALUES ( (SELECT id FROM osticket.ost_user WHERE name = '".$_POST['firstname']." ".$_POST['lastname']."'), '".$_POST['phone']."', '".$_POST['notes']."' )";
                $query3 = db_query($sql3);
                $sql5 = "SELECT * FROM osticket.ost_user WHERE name = '".$_POST['firstname']." ".$_POST['lastname']."'";
                $query5 = db_query($sql5);

                foreach ($query5 as $row) {
                    $sql4 = "UPDATE osticket.ost_user SET default_email_id = (SELECT id FROM osticket.ost_user_email WHERE user_id = '".$row['id']."') WHERE id = '".$row['id']."'";
                    $query4 = db_query($sql4);
                    $sql6 = "UPDATE osticket.ost_staff SET staff_user_id = '".$row['id']."' WHERE staff_id = '".$staff->getId()."'";
                    $query6 = db_query($sql6);
                }

                unset($_SESSION['new-agent-passwd']);
                $msg=sprintf(__('Successfully added %s.'),Format::htmlchars($_POST['firstname']));
                $_REQUEST['a']=null;
            }elseif(!$errors['err']){
                $errors['err']=sprintf('%s %s',
                    sprintf(__('Unable to add %s.'), __('this agent')),
                    __('Correct any errors below and try again.'));
            }
            break;
        case 'mass_process':
            if(!$_POST['ids'] || !is_array($_POST['ids']) || !count($_POST['ids'])) {
                $errors['err'] = sprintf(__('You must select at least %s.'),
                    __('one agent'));
            } elseif(in_array($_POST['a'], array('disable', 'delete'))
                && in_array($thisstaff->getId(),$_POST['ids'])
            ) {
                $errors['err'] = __('You can not disable/delete yourself - you could be the only admin!');
            } else {
                $count = count($_POST['ids']);
                $members = Staff::objects()->filter(array(
                    'staff_id__in' => $_POST['ids']
                ));
                switch(strtolower($_POST['a'])) {
                    case 'enable':
                        $num = $members->update(array('isactive' => 1));
                        if ($num) {
                            if($num==$count)
                                $msg = sprintf('Successfully activated %s',
                                    _N('selected agent', 'selected agents', $count));
                            else
                                $warn = sprintf(__('%1$d of %2$d %3$s activated'), $num, $count,
                                    _N('selected agent', 'selected agents', $count));
                        } else {
                            $errors['err'] = sprintf(__('Unable to activate %s'),
                                _N('selected agent', 'selected agents', $count));
                        }
                        break;

                    case 'disable':
                        $num = $members->update(array('isactive' => 0));
                        if ($num) {
                            if($num==$count)
                                $msg = sprintf('Successfully disabled %s',
                                    _N('selected agent', 'selected agents', $count));
                            else
                                $warn = sprintf(__('%1$d of %2$d %3$s disabled'), $num, $count,
                                    _N('selected agent', 'selected agents', $count));
                        } else {
                            $errors['err'] = sprintf(__('Unable to disable %s'),
                                _N('selected agent', 'selected agents', $count));
                        }
                        break;

                    case 'delete':
                        $i = 0;
                        foreach($members as $s) {
                            if ($s->staff_id != $thisstaff->getId() && $s->delete())
                                $i++;
                        }

                        if($i && $i==$count)
                            $msg = sprintf(__('Successfully deleted %s.'),
                                _N('selected agent', 'selected agents', $count));
                        elseif($i>0)
                            $warn = sprintf(__('%1$d of %2$d %3$s deleted'), $i, $count,
                                _N('selected agent', 'selected agents', $count));
                        elseif(!$errors['err'])
                            $errors['err'] = sprintf(__('Unable to delete %s.'),
                                _N('selected agent', 'selected agents', $count));
                        break;

                    case 'permissions':
                        foreach ($members as $s)
                            if ($s->updatePerms($_POST['perms'], $errors) && $s->save())
                                $i++;

                        if($i && $i==$count)
                            $msg = sprintf(__('Successfully updated %s.'),
                                _N('selected agent', 'selected agents', $count));
                        elseif($i>0)
                            $warn = sprintf(__('%1$d of %2$d %3$s updated'), $i, $count,
                                _N('selected agent', 'selected agents', $count));
                        elseif(!$errors['err'])
                            $errors['err'] = sprintf(__('Unable to update %s.'),
                                _N('selected agent', 'selected agents', $count));
                        break;

                    case 'department':
                        if (!$_POST['dept_id'] || !$_POST['role_id']
                            || !Dept::lookup($_POST['dept_id'])
                            || !Role::lookup($_POST['role_id'])
                        ) {
                            $errors['err'] = __('Internal error occurred');
                            break;
                        }
                        foreach ($members as $s) {
                            $s->setDepartmentId((int) $_POST['dept_id'], $_POST['eavesdrop']);
                            $s->role_id = (int) $_POST['role_id'];
                            if ($s->save() && $s->dept_access->saveAll())
                                $i++;
                        }
                        if($i && $i==$count)
                            $msg = sprintf(__('Successfully updated %s.'),
                                _N('selected agent', 'selected agents', $count));
                        elseif($i>0)
                            $warn = sprintf(__('%1$d of %2$d %3$s updated'), $i, $count,
                                _N('selected agent', 'selected agents', $count));
                        elseif(!$errors['err'])
                            $errors['err'] = sprintf(__('Unable to update %s.'),
                                _N('selected agent', 'selected agents', $count));
                        break;

                    default:
                        $errors['err'] = sprintf('%s - %s', __('Unknown action'), __('Get technical help!'));
                }

            }
            break;
        default:
            $errors['err']=__('Unknown action');
            break;
    }
}

$page='staffmembers.inc.php';
$tip_namespace = 'staff.agent';
if($staff || ($_REQUEST['a'] && !strcasecmp($_REQUEST['a'],'add'))) {
    $page='staff.inc.php';
}

$nav->setTabActive('staff');
$ost->addExtraHeader('<meta name="tip-namespace" content="' . $tip_namespace . '" />',
    "$('#content').data('tipNamespace', '".$tip_namespace."');");
require(STAFFINC_DIR.'header.inc.php');
require(STAFFINC_DIR.$page);
include(STAFFINC_DIR.'footer.inc.php');
?>
