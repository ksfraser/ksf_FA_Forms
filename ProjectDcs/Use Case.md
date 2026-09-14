# ksf_FA_Forms - Use Case Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Approved

---

## 1. Introduction

### 1.1 Purpose

This document captures all use cases for the FA_Forms module.

### 1.2 Actor Definitions

| Actor | Description | Access Level |
|-------|-------------|--------------|
| Admin | Create and manage forms | SA_FORMSCREATE |
| CRM Manager | View submissions, link to customers | SA_FORMSVIEW |
| Customer | Submit forms | Public/Portal |
| System | Validate and store submissions | Automatic |

---

## 2. Use Case Catalog

### 2.1 Form Management Use Cases

| Use Case ID | Use Case Name |
|-------------|---------------|
| UC-FRM-001 | Create New Form |
| UC-FRM-002 | Edit Form |
| UC-FRM-003 | Delete Form |
| UC-FRM-004 | View Form List |
| UC-FRM-005 | Activate/Deactivate Form |

### 2.2 Submission Use Cases

| Use Case ID | Use Case Name |
|-------------|---------------|
| UC-FRM-006 | Submit Form |
| UC-FRM-007 | View Submissions |
| UC-FRM-008 | View Submission Details |
| UC-FRM-009 | Delete Submission |
| UC-FRM-010 | Export Submissions |

### 2.3 CRM Integration Use Cases

| Use Case ID | Use Case Name |
|-------------|---------------|
| UC-FRM-011 | Link Submission to Customer |
| UC-FRM-012 | View Customer Submission History |

---

## 3. Detailed Use Cases

---

### UC-FRM-001: Create New Form

**Primary Actor:** Admin  
**Trigger:** Need to create a new form

**Preconditions:**
1. User authenticated with SA_FORMSCREATE
2. No form with same name exists

**Basic Flow:**
```
1. Navigate to CRM > Form Builder
2. Click "Create New Form"
3. Enter form details:
   - Name: "Customer Feedback Form"
   - Description: "Collect customer feedback"
4. Define form fields (JSON):
   - Field 1: customer_name (text, required)
   - Field 2: email (email, required)
   - Field 3: rating (select, required)
     Options: [Excellent, Good, Fair, Poor]
   - Field 4: comments (textarea, optional)
5. Set status: Inactive (for testing)
6. Save form
7. Verify form appears in list
```

**Alternative Flow:**

A1: Duplicate Form Name
```
3a. Enter name already used
3b. System shows error: "Form name already exists"
3c. User enters unique name
```

A2: Invalid Field JSON
```
4a. Enter invalid JSON
4b. System shows validation error
4c. User corrects JSON
```

---

### UC-FRM-002: Edit Form

**Primary Actor:** Admin  
**Trigger:** Need to modify form

**Basic Flow:**
```
1. Select form from list
2. Click "Edit"
3. Modify fields:
   - Change description
   - Add new field
   - Remove optional field
   - Change field required status
4. Save changes
5. Verify changes reflected
```

---

### UC-FRM-003: Delete Form

**Primary Actor:** Admin  
**Trigger:** Form no longer needed

**Basic Flow:**
```
1. Select form
2. Click "Delete"
3. Confirm deletion
4. If form has submissions, confirm again
5. Form and submissions deleted
```

---

### UC-FRM-004: View Form List

**Primary Actor:** Admin, CRM Manager  
**Trigger:** Navigate to forms

**Basic Flow:**
```
1. Navigate to CRM > Form Builder
2. View all forms with columns:
   - Name, Status, Fields, Submissions, Created
3. Apply filters as needed
4. Click form to view details
```

---

### UC-FRM-005: Activate/Deactivate Form

**Primary Actor:** Admin  
**Trigger:** Toggle form availability

**Basic Flow:**
```
1. Select form
2. Click "Activate" or "Deactivate"
3. Status updated
4. If deactivated, new submissions rejected
5. Existing submissions preserved
```

---

### UC-FRM-006: Submit Form

**Primary Actor:** Customer, System  
**Trigger:** User submits form data

**Preconditions:**
1. Form exists and is active
2. User has access to form

**Basic Flow:**
```
1. User accesses form (public URL or portal)
2. Form fields displayed
3. User fills fields:
   - customer_name: "Jane Smith"
   - email: "jane@example.com"
   - rating: "Good"
   - comments: "Great service!"
4. User submits form
5. System validates:
   - Required fields present
   - Email format valid
   - All fields pass validation
6. System stores submission:
   - form_id: 1
   - submission_data: {name, email, rating, comments}
   - submitter_email: "jane@example.com"
   - submitter_name: "Jane Smith"
   - debtor_no: (looked up from email if exists)
   - submitted_at: timestamp
7. System shows success message
8. Email notification sent (if configured)
```

**Alternative Flow:**

A1: Validation Error
```
5a. Required field missing
5b. System shows error: "Customer name is required"
5c. Other fields preserved
5d. User corrects and resubmits
```

A2: Invalid Email
```
5a. Enter invalid email format
5b. System shows: "Please enter a valid email address"
5c. User corrects
```

A3: Inactive Form
```
1a. Form is inactive
2a. System shows: "This form is not currently accepting submissions"
```

---

### UC-FRM-007: View Submissions

**Primary Actor:** Admin, CRM Manager  
**Trigger:** Review form submissions

**Basic Flow:**
```
1. Navigate to CRM > Submissions
2. View all submissions with columns:
   - Form Name, Submitter, Email, Date, Status
3. Apply filters:
   - By form
   - By date range
   - By submitter
4. Click submission to view details
```

---

### UC-FRM-008: View Submission Details

**Primary Actor:** Admin, CRM Manager  
**Trigger:** Examine specific submission

**Basic Flow:**
```
1. Click on submission from list
2. View full details:
   - All field values
   - Submitter info
   - Linked customer (if any)
   - Submission timestamp
3. Take actions:
   - Mark as read
   - Add notes
   - Link to customer (if not already)
```

---

### UC-FRM-009: Delete Submission

**Primary Actor:** Admin  
**Trigger:** Remove unwanted submission

**Basic Flow:**
```
1. Select submission
2. Click "Delete"
3. Confirm deletion
4. Submission removed
```

---

### UC-FRM-010: Export Submissions

**Primary Actor:** Admin, CRM Manager  
**Trigger:** Need submission data for external use

**Basic Flow:**
```
1. Navigate to submissions (optionally filtered)
2. Click "Export to CSV"
3. Select fields to include (or all)
4. System generates CSV file
5. Browser downloads file
```

---

### UC-FRM-011: Link Submission to Customer

**Primary Actor:** System, Admin  
**Trigger:** Associate submission with CRM record

**Basic Flow:**
```
1. Submission received
2. System checks submitter email against CRM
3. If match found:
   - debtor_no populated
   - Submission linked to customer
4. If no match:
   - debtor_no remains null
   - Admin can manually link
```

---

### UC-FRM-012: View Customer Submission History

**Primary Actor:** CRM Manager  
**Trigger:** Review customer's form submissions

**Basic Flow:**
```
1. Open customer record in CRM
2. Navigate to "Submissions" tab
3. View all submissions from customer
4. Filter by form type, date
5. Click to view details
```

---

## 4. Use Case Matrix

| Actor | Create | Edit | Delete | View List | Submit | View Submissions | Export |
|-------|--------|------|--------|-----------|--------|------------------|--------|
| Admin | ● | ● | ● | ● | ○ | ● | ● |
| CRM Manager | ○ | ○ | ○ | ● | ○ | ● | ● |
| Customer | ○ | ○ | ○ | ○ | ● | ○ | ○ |
| System | ○ | ○ | ○ | ○ | ● | ○ | ○ |

● = Primary, ○ = Secondary

---

## 5. Error Handling Summary

| Scenario | Error | Handling |
|----------|-------|----------|
| Duplicate form name | "Form name already exists" | Prevent save |
| Invalid field JSON | "Invalid field configuration" | Show validation error |
| Missing required field | "{Field name} is required" | Highlight field |
| Invalid email format | "Please enter a valid email" | Highlight field |
| Inactive form submission | "Form not accepting submissions" | Show message |
| Database error | "Submission failed" | Log error, show message |