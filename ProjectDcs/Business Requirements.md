# ksf_FA_Forms - Business Requirements Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Approved

---

## 1. Introduction

### 1.1 Purpose

The FA_Forms module provides a form builder and submission management system for FrontAccounting. It enables businesses to create custom forms, collect data from customers and employees, and manage submissions - similar to WordPress Contact Form 7 (CF7) functionality integrated into the FA ecosystem.

### 1.2 Problem Statement

Organizations using FrontAccounting need to collect various types of information:
- Customer feedback and surveys
- Support requests
- Order special requests
- Employee onboarding forms
- Contact information updates

Without a form system, they must rely on:
- Email submissions (disorganized)
- Paper forms (not searchable)
- External form services (cost, integration issues)

### 1.3 Scope

This module provides:

1. **Form Builder** - Create custom forms with various field types
2. **Field Types** - Support for text, email, phone, select, checkbox, etc.
3. **Form Submission** - Collect and store form data
4. **CRM Integration** - Link submissions to customer records
5. **CF7 Compatibility** - WordPress Contact Form 7 integration (future)

---

## 2. Module Overview

### 2.1 Core Features

| Feature | Description | Priority |
|---------|-------------|----------|
| Form Creation | Build custom forms with drag-drop or code | Critical |
| Field Types | Text, email, phone, select, textarea, etc. | Critical |
| Form Validation | Client and server-side validation | High |
| Submission Storage | Store submissions in database | Critical |
| Submission View | View and manage submissions | High |
| Customer Linking | Link submissions to CRM records | High |
| Form Status | Activate/deactivate forms | Medium |
| CF7 Integration | Import/export CF7 format (future) | Medium |

### 2.2 Supported Field Types

| Field Type | Description | Validation |
|------------|-------------|------------|
| Text | Single line text input | Required, max length |
| Textarea | Multi-line text input | Required, max length |
| Email | Email address input | Email format |
| Phone | Phone number input | Phone format |
| Number | Numeric input | Min, max, step |
| Select | Dropdown selection | Required |
| Radio | Single selection radio buttons | Required |
| Checkbox | Multiple selection checkboxes | Min, max selected |
| Date | Date picker | Date format |
| Hidden | Hidden field (for tracking) | - |

### 2.3 Form States

| State | Description |
|-------|-------------|
| Active | Form accepting submissions |
| Inactive | Form not accepting submissions |
| Archived | Form no longer in use |

---

## 3. User Stories

### 3.1 Admin/User

> As an Admin, I want to create custom forms so that I can collect specific information from users.

**Acceptance Criteria:**
- Can create forms with multiple field types
- Can set field validation rules
- Can preview form before publishing
- Can activate/deactivate forms

### 3.2 Customer

> As a Customer, I want to fill out forms on the FA portal so that I can submit requests and feedback.

**Acceptance Criteria:**
- Can view and fill active forms
- Receives validation errors for invalid input
- Submission confirmation displayed
- Email notification sent (optional)

### 3.3 CRM Manager

> As a CRM Manager, I want to link form submissions to customer records so that I can track all customer interactions.

**Acceptance Criteria:**
- Submissions linked to debtor_no
- Can view customer submission history
- Can segment by submission type

---

## 4. Integration Dependencies

### 4.1 Required Modules

| Module | Dependency Type | Purpose |
|--------|-----------------|---------|
| FrontAccounting Core | Required | Platform foundation |
| ksf_FA_CRM | Optional | Customer linking |

### 4.2 Optional Integrations

| Integration | Purpose |
|-------------|---------|
| ksf_FA_Coupons | Form for promotion signups |
| Email System | Submission notifications |

### 4.3 Data Dependencies

| External Table | Relationship | Purpose |
|---------------|--------------|---------|
| `{PREFIX}debtors` | Via CRM | Customer linking |
| `{PREFIX}contacts` | Via CRM | Contact information |

---

## 5. Database Schema

### 5.1 Primary Tables

#### `fa_forms`
Stores form definitions.

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT (PK) | Primary key |
| `name` | VARCHAR(100) | Form name |
| `description` | TEXT | Form description |
| `form_fields` | JSON | Field definitions |
| `status` | VARCHAR(20) | active/inactive/archived |
| `cf7_integration` | TINYINT(1) | CF7 compatibility flag |
| `created_at` | TIMESTAMP | Creation timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |

#### `fa_form_submissions`
Stores form submission data.

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT (PK) | Primary key |
| `form_id` | INT (FK) | Form reference |
| `submission_data` | JSON | Submitted field values |
| `submitter_email` | VARCHAR(100) | Submitter email |
| `submitter_name` | VARCHAR(100) | Submitter name |
| `debtor_no` | VARCHAR(20) | Customer reference |
| `submitted_at` | TIMESTAMP | Submission timestamp |

---

## 6. Security Model

### 6.1 Security Areas

| Area | Code | Description |
|------|------|-------------|
| SS_FORMS | 118 << 8 | Form Builder section |
| SA_FORMSVIEW | SS_FORMS \| 1 | View forms |
| SA_FORMSCREATE | SS_FORMS \| 2 | Create/edit forms |

### 6.2 Access Control

- View: All users with CRM access
- Create/Edit: Admin, CRM Manager

---

## 7. Menu Structure

| Menu Item | Path | Security |
|-----------|------|----------|
| Form Builder | forms.php | SA_FORMSVIEW |
| Submissions | submissions.php | SA_FORMSVIEW |

---

## 8. Success Metrics

| Metric | Target |
|--------|--------|
| Form creation time | < 5 minutes |
| Submission storage | 100% data preserved |
| Validation accuracy | 100% |
| System response time | < 1s |

---

## 9. Future Enhancements

1. **Drag-Drop Builder** - Visual form builder interface
2. **Conditional Logic** - Show/hide fields based on input
3. **File Uploads** - Accept file attachments
4. **CF7 Import/Export** - WordPress CF7 compatibility
5. **Email Notifications** - Configurable email alerts
6. **Webhooks** - Send submissions to external systems
7. **PDF Generation** - Create PDF from submissions