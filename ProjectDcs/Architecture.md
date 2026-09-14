# ksf_FA_Forms - Architecture Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Approved

---

## 1. Architecture Overview

### 1.1 Module Purpose

The FA_Forms module provides a form builder and submission management system for FrontAccounting. It enables creation of custom forms with various field types, submission storage, and CRM integration.

### 1.2 Architecture Pattern

The module follows the **Business Logic + Platform Adapter** pattern:

```
ksf_FA_Forms/                  # Platform-specific UI & DB adapters
    └── Ksfraser\FA\Forms\
```

---

## 2. Component Architecture

### 2.1 Module Structure

```
ksf_FA_Forms/
├── sql/                          # Database schemas
│   └── update.sql               # Schema installation
├── includes/                     # FA-specific database classes
│   └── forms_db.inc             # Form CRUD operations
├── pages/                        # FA admin UI pages
│   ├── forms.php                 # Form builder
│   └── submissions.php           # Submission management
├── hooks.php                    # FA module hooks
├── composer.json
├── phpunit.xml
├── tests/                       # Unit tests
│   └── bootstrap.php
└── ProjectDcs/                  # Project documentation
```

---

## 3. Class Diagram

```
┌─────────────────────────────────────────────────────────┐
│                   FA Module Layer                        │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌─────────────────────────────────────────────────┐   │
│  │         hooks_fa_forms                           │   │
│  │         extends hooks                            │   │
│  ├─────────────────────────────────────────────────┤   │
│  │  + install_options($app): void                  │   │
│  │  + install_access(): array                      │   │
│  │  + activate_extension(): bool                    │   │
│  │  + ensure_forms_schema(): void                   │   │
│  │  + db_prevoid(): void                           │   │
│  └─────────────────────────────────────────────────┘   │
│                          │                               │
│                          ▼                               │
│  ┌─────────────────────────────────────────────────┐   │
│  │              FA UI Layer                        │   │
│  ├─────────────────────────────────────────────────┤   │
│  │  forms.php (Form Builder)                       │   │
│  │  - Form list view                               │   │
│  │  - Form editor (future)                         │   │
│  │  submissions.php (Submission Management)        │   │
│  │  - Submission list                              │   │
│  │  - Submission details                          │   │
│  └─────────────────────────────────────────────────┘   │
│                          │                               │
│                          ▼                               │
│  ┌─────────────────────────────────────────────────┐   │
│  │            FA Database Layer                     │   │
│  ├─────────────────────────────────────────────────┤   │
│  │  forms_db.inc                                   │   │
│  │  - get_forms()                                  │   │
│  │  - get_form_by_id()                             │   │
│  │  - get_submissions()                            │   │
│  │  - save_submission()                            │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## 4. Database Architecture

### 4.1 Entity Relationship Diagram

```
┌─────────────────────┐         ┌─────────────────────────┐
│      fa_forms       │         │  fa_form_submissions    │
├─────────────────────┤         ├─────────────────────────┤
│ PK id               │──────┐  │ PK id                   │
│    name             │      │  │ FK form_id         ─────┘
│    description      │      │  │    submission_data (JSON)
│    form_fields      │      │  │    submitter_email
│    status           │      │  │    submitter_name
│    cf7_integration  │      │  │    debtor_no
│    created_at       │      │  │    submitted_at
│    updated_at       │      │  └─────────────────────────┘
└─────────────────────┘      │
                              │
                              ▼
                    ┌─────────────────────────┐
                    │    CRM Linkage          │
                    ├─────────────────────────┤
                    │  Via ksf_FA_CRM:        │
                    │  - debtors             │
                    │  - contacts            │
                    └─────────────────────────┘
```

---

## 5. JSON Schema

### 5.1 Form Fields JSON Structure

```json
{
  "fields": [
    {
      "name": "customer_name",
      "label": "Customer Name",
      "type": "text",
      "required": true,
      "max_length": 100
    },
    {
      "name": "email",
      "label": "Email Address",
      "type": "email",
      "required": true
    },
    {
      "name": "phone",
      "label": "Phone Number",
      "type": "phone",
      "required": false
    },
    {
      "name": "inquiry_type",
      "label": "Inquiry Type",
      "type": "select",
      "required": true,
      "options": ["Support", "Sales", "General"]
    },
    {
      "name": "message",
      "label": "Message",
      "type": "textarea",
      "required": true,
      "max_length": 1000
    }
  ]
}
```

### 5.2 Submission Data JSON Structure

```json
{
  "customer_name": "John Doe",
  "email": "john@example.com",
  "phone": "555-1234",
  "inquiry_type": "Support",
  "message": "I need help with my order."
}
```

---

## 6. Hook Integration

### 6.1 FA Hook Registration

```php
class hooks_fa_forms extends hooks {
    var $module_name = 'fa_forms';
    
    function install_options($app) {
        switch($app->id) {
            case 'CRM':
                $app->add_lapp_function(0, _("Form Builder"),
                    $path_to_root."/modules/".$this->module_name."/forms.php", 
                    'SA_FORMSVIEW', MENU_ENTRY);
                $app->add_lapp_function(1, _("Submissions"),
                    $path_to_root."/modules/".$this->module_name."/submissions.php", 
                    'SA_FORMSCREATE', MENU_ENTRY);
                break;
        }
    }
    
    function install_access() {
        $security_sections[SS_FORMS] = _("Form Builder");
        $security_areas['SA_FORMSVIEW'] = array(SS_FORMS | 1, _("View Forms"));
        $security_areas['SA_FORMSCREATE'] = array(SS_FORMS | 2, _("Create Forms"));
        return array($security_areas, $security_sections);
    }
}
```

---

## 7. Extension Activation

### 7.1 Schema Installation

The module installs the full schema on extension activation:

```php
function activate_extension($company, $check_only=true) {
    $updates = array('sql/update.sql' => array($this->module_name));
    $ok = $this->update_databases($company, $updates, $check_only);
    if ($check_only || !$ok) {
        return $ok;
    }
    $this->ensure_forms_schema();
    return $ok;
}

private function ensure_forms_schema() {
    // fa_forms - Form definitions
    // fa_form_submissions - Submission data
}
```

---

## 8. Page Architecture

### 8.1 Form Builder (forms.php)

Provides form management interface:
- List all forms
- Create new form
- Edit form fields (JSON editor or UI)
- Activate/deactivate forms

### 8.2 Submissions (submissions.php)

Provides submission management:
- List all submissions
- Filter by form, date, submitter
- View submission details
- Export submissions

---

## 9. Validation Flow

### 9.1 Client-Side Validation

```javascript
// Form field validation
- Required fields checked
- Email format validated
- Phone format validated
- Max length enforced
```

### 9.2 Server-Side Validation

```php
// On submission
1. Check form exists and is active
2. For each field:
   a. Check required
   b. Validate format
   c. Check length
3. If valid, save to fa_form_submissions
4. Return success/error
```

---

## 10. Future Architecture (KSF II)

For future versions:

```
┌─────────────────────────────────────────────────────────┐
│               FrontAccounting Adapter                    │
├─────────────────────────────────────────────────────────┤
│  hooks_fa_forms                                        │
└────────────────────────┬────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────┐
│              Core Business Layer                          │
├─────────────────────────────────────────────────────────┤
│  Ksfraser\Forms\Services\FormService                    │
│  Ksfraser\Forms\Services\SubmissionService              │
│  Ksfraser\Forms\Entities\Form                           │
│  Ksfraser\Forms\Entities\Submission                    │
│  Ksfraser\Forms\Contracts\FormFieldInterface           │
│  Ksfraser\Forms\Validators\FieldValidator              │
└─────────────────────────────────────────────────────────┘
```

---

## 11. Technology Stack

| Component | Technology | Version |
|-----------|------------|---------|
| Framework | FrontAccounting | 2.4+ |
| Database | MySQL/MariaDB | 5.7+ |
| PHP | PHP | 7.3+ |
| Testing | PHPUnit | 9.x |
| Frontend | FA UI Framework | Native |
| JSON | Native PHP | - |

---

## 12. Error Handling

| Error Type | Handling |
|------------|----------|
| Invalid form ID | Display 404 page |
| Missing required field | Show field error |
| Invalid email format | Display validation message |
| Database error | Log error, show generic message |
| Inactive form submission | Reject with message |