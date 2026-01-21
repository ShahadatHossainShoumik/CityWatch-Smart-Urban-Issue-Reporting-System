<?php

session_start();

require_once '../Model/AdminModel.php';
require_once '../Model/UserModel.php';
require_once '../Model/IssueModel.php';
require_once '../Model/AnnouncementModel.php';

// Check if user is admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    if(isset($_POST['ajax'])){
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
        exit();
    }
    header("Location: ../View/login.php");
    exit();
}

// Check if this is an AJAX request
$isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

// Function to send JSON response
function sendJsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

// Handle citizen operations
if(isset($_POST['action']) && $_POST['action'] === 'add_citizen'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address'] ?? '');
    
    if($name && $email && $phone && $password){
        $result = createUser($name, $email, $phone, $password, 'citizen', $address);
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Citizen added successfully!");
            } else {
                sendJsonResponse(false, "Failed to add citizen");
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Citizen added successfully!";
        } else {
            $_SESSION['msg'] = "Failed to add citizen";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "All fields are required");
        }
        $_SESSION['msg'] = "All fields are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_citizen.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'edit_citizen'){
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $nid = trim($_POST['nid'] ?? '');
    
    if($name && $email){
        $result = updateUser($id, $name, $email, $mobile, $dob, $nid, 'citizen');
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Citizen updated successfully!", ['id' => $id]);
            } else {
                sendJsonResponse(false, "Failed to update citizen", ['id' => $id]);
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Citizen updated successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update citizen";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "Name and email are required");
        }
        $_SESSION['msg'] = "Name and email are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_citizen.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'delete_citizen'){
    $id = intval($_POST['id']);
    $result = deleteUser($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "Citizen deleted successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to delete citizen", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "Citizen deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete citizen";
    }
    header("Location: ../View/Admin/manage_citizen.php");
    exit();
}

// Handle authority operations
if(isset($_POST['action']) && $_POST['action'] === 'add_authority'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address'] ?? '');
    
    if($name && $email && $phone && $password){
        $result = createUser($name, $email, $phone, $password, 'authority', $address);
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Authority added successfully!");
            } else {
                sendJsonResponse(false, "Failed to add authority");
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Authority added successfully!";
        } else {
            $_SESSION['msg'] = "Failed to add authority";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "All fields are required");
        }
        $_SESSION['msg'] = "All fields are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_authority.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'edit_authority'){
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $nid = trim($_POST['nid'] ?? '');
    
    if($name && $email){
        $result = updateUser($id, $name, $email, $mobile, $dob, $nid, 'authority');
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Authority updated successfully!", ['id' => $id]);
            } else {
                sendJsonResponse(false, "Failed to update authority", ['id' => $id]);
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Authority updated successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update authority";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "Name and email are required");
        }
        $_SESSION['msg'] = "Name and email are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_authority.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'delete_authority'){
    $id = intval($_POST['id']);
    $result = deleteUser($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "Authority deleted successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to delete authority", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "Authority deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete authority";
    }
    header("Location: ../View/Admin/manage_authority.php");
    exit();
}

// Handle admin operations
if(isset($_POST['action']) && $_POST['action'] === 'add_admin'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address'] ?? '');
    
    if($name && $email && $phone && $password){
        $result = createUser($name, $email, $phone, $password, 'admin', $address);
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Admin added successfully!");
            } else {
                sendJsonResponse(false, "Failed to add admin");
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Admin added successfully!";
        } else {
            $_SESSION['msg'] = "Failed to add admin";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "All fields are required");
        }
        $_SESSION['msg'] = "All fields are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_admin.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'edit_admin'){
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $nid = trim($_POST['nid'] ?? '');
    
    if($name && $email){
        $result = updateUser($id, $name, $email, $mobile, $dob, $nid, 'admin');
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Admin updated successfully!", ['id' => $id]);
            } else {
                sendJsonResponse(false, "Failed to update admin", ['id' => $id]);
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Admin updated successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update admin";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "Name and email are required");
        }
        $_SESSION['msg'] = "Name and email are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_admin.php");
    }
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'delete_admin'){
    $id = intval($_POST['id']);
    $result = deleteUser($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "Admin deleted successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to delete admin", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "Admin deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete admin";
    }
    header("Location: ../View/Admin/manage_admin.php");
    exit();
}

// Handle block/unblock user operations
if(isset($_POST['action']) && $_POST['action'] === 'block_user'){
    $id = intval($_POST['id']);
    $result = blockUser($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "User blocked successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to block user", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "User blocked successfully!";
    } else {
        $_SESSION['msg'] = "Failed to block user";
    }
    header("Location: ../View/Admin/fake_reports.php");
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'unblock_user'){
    $id = intval($_POST['id']);
    $result = unblockUser($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "User unblocked successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to unblock user", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "User unblocked successfully!";
    } else {
        $_SESSION['msg'] = "Failed to unblock user";
    }
    header("Location: ../View/Admin/fake_reports.php");
    exit();
}

// Handle incident operations
if(isset($_POST['action']) && $_POST['action'] === 'update_incident_status'){
    $id = intval($_POST['id']);
    $status = trim($_POST['status']);
    
    if($id && in_array($status, ['pending', 'reviewed', 'resolved'])){
        $result = updateIssueStatus($id, $status);
        if($result){
            $_SESSION['msg'] = "Incident status updated!";
        } else {
            $_SESSION['msg'] = "Failed to update incident";
        }
    }
    header("Location: ../View/Admin/manage_incidents.php");
    exit();
}

if(isset($_POST['action']) && $_POST['action'] === 'delete_incident'){
    $id = intval($_POST['id']);
    $result = deleteIssueForAdmin($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "Incident deleted successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to delete incident", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "Incident deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete incident";
    }
    header("Location: ../View/Admin/manage_incidents.php");
    exit();
}

// Handle announcement operations
if(isset($_POST['action']) && $_POST['action'] === 'delete_announcement'){
    $id = intval($_POST['id']);
    $result = deleteAnnouncement($id);
    
    if($isAjax){
        if($result){
            sendJsonResponse(true, "Announcement deleted successfully!", ['id' => $id]);
        } else {
            sendJsonResponse(false, "Failed to delete announcement", ['id' => $id]);
        }
    }
    
    if($result){
        $_SESSION['msg'] = "Announcement deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete announcement";
    }
    header("Location: ../View/Admin/manage_announcement.php");
    exit();
}

// Handle edit announcement
if(isset($_POST['action']) && $_POST['action'] === 'edit_announcement'){
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $message = trim($_POST['message']);
    
    if($id && $title && $message){
        $result = updateAnnouncement($id, $_SESSION['id'], $title, $message);
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Announcement updated successfully!", ['id' => $id]);
            } else {
                sendJsonResponse(false, "Failed to update announcement", ['id' => $id]);
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Announcement updated successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update announcement";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "All fields are required");
        }
        $_SESSION['msg'] = "All fields are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_announcement.php");
    }
    exit();
}

// Handle edit incident
if(isset($_POST['action']) && $_POST['action'] === 'edit_incident'){
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $status = trim($_POST['status']);
    
    if($id && $title && $location && $description){
        // First update the issue details
        $result = updateIssueForAdmin($id, $title, $description, $location);
        
        // Then update the status if provided
        if($result && $status){
            updateIssueStatus($id, $status);
        }
        
        if($isAjax){
            if($result){
                sendJsonResponse(true, "Incident updated successfully!", ['id' => $id]);
            } else {
                sendJsonResponse(false, "Failed to update incident", ['id' => $id]);
            }
        }
        
        if($result){
            $_SESSION['msg'] = "Incident updated successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update incident";
        }
    } else {
        if($isAjax){
            sendJsonResponse(false, "All fields are required");
        }
        $_SESSION['msg'] = "All fields are required";
    }
    
    if(!$isAjax){
        header("Location: ../View/Admin/manage_incidents.php");
    }
    exit();
}

