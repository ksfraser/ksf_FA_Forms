# ksf_FA_Forms - Functional Requirements Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Approved

---

## 1. Introduction

### 1.1 Purpose

This document details the functional requirements for the FA_Forms module.

### 1.2 Scope

- Form creation and management
- Field type support
- Form validation
- Submission storage and retrieval
- CRM integration

---

## 2. Functional Requirements

### 2.1 Form Management

#### FR-FRM-001: Create Form

**Description:** Create a new form with name and fields.

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| name | VARCHAR(100) | Yes | Form name (unique) |
| description | TEXT | No | Form description |
| form_fields | JSON | Yes | Field definitions |
| status | VARCHAR(20) | No | active/inactive (default: inactive) |
| cf7_integration | TINYINT(1) | No | CF7 format flag |

**Form Fields JSON Structure:**
```json
{
  "fields": [
    {
      "name": "field_name",
      "label": "Display Label",
      "type": "text|email|phone|textarea|select|radio|checkbox|date|hidden",
      "required": true|false,
      "options": ["opt1", "opt2"], // for select, radio, checkbox
      "max_length": 255, // for text, textarea
      "min": 0, // for number
      "max": 100 // for number
    }
  ]
}
```

**Acceptance Criteria:**
- [ ] Can create form with name and fields
- [ ] Name uniqueness validated
- [ ] JSON schema validated
- [ ] Form created in inactive status

---

#### FR-FRM-002: Edit Form

**Description:** Modify existing form.

**Editable Fields:**
- name
- description
- form_fields
- status

**Acceptance Criteria:**
- [ ] Can modify form details
- [ ] Field changes validated
- [ ] Existing submissions preserved

---

#### FR-FRM-003: Delete Form

**Description:** Remove form from system.

**Business Rules:**
- Form with submissions can be deleted
- Submissions deleted via CASCADE
- Archived forms can be deleted

**Acceptance Criteria:**
- [ ] Form deleted
- [ ] Submissions deleted (if any)
- [ ] Form no longer accessible

---

#### FR-FRM-004: View Form List

**Description:** Display all forms with status.

**Columns:**
- Name
- Description (truncated)
- Status
- Field Count
- Submission Count
- Created Date

**Filters:**
- Status (Active, Inactive, All)
- Name search

**Acceptance Criteria:**
- [ ] All forms displayed
- [ ] Filters work correctly
- [ ] Submission count shown

---

#### FR-FRM-005: Activate/Deactivate Form

**Description:** Toggle form availability for submissions.

**Activation:**
- Form accepts new submissions
- Form visible to users

**Deactivation:**
- Form rejects new submissions
- Existing submissions preserved

**Acceptance Criteria:**
- [ ] Status toggle works
- [ ] Deactivated form rejects submissions
- [ ] Messages clearly communicated

---

### 2.2 Field Types

#### FR-FRM-006: Text Field

**Description:** Single line text input.

**Configuration:**
- required: boolean
- max_length: 1-255

**Validation:**
- Not empty (if required)
- Max length enforced

**Acceptance Criteria:**
- [ ] Text input rendered
- [ ] Required validation works
- [ ] Max length enforced

---

#### FR-FRM-007: Textarea Field

**Description:** Multi-line text input.

**Configuration:**
- required: boolean
- max_length: 1-10000

**Acceptance Criteria:**
- [ ] Textarea rendered
- [ ] Multi-line input works
- [ ] Max length enforced

---

#### FR-FRM-008: Email Field

**Description:** Email address input.

**Configuration:**
- required: boolean

**Validation:**
- Email format (regex or filter_var)

**Acceptance Criteria:**
- [ ] Email input rendered
- [ ] Email format validated
- [ ] Invalid format rejected

---

#### FR-FRM-009: Phone Field

**Description:** Phone number input.

**Configuration:**
- required: boolean

**Validation:**
- Phone format (flexible: allows digits, spaces, dashes, parens, +)

**Acceptance Criteria:**
- [ ] Phone input rendered
- [ ] Phone format validated
- [ ] Various formats accepted

---

#### FR-FRM-010: Number Field

**Description:** Numeric input.

**Configuration:**
- required: boolean
- min: number (optional)
- max: number (optional)
- step: number (optional)

**Validation:**
- Numeric value
- Min/max range

**Acceptance Criteria:**
- [ ] Number input rendered
- [ ] Min/max enforced
- [ ] Step enforced

---

#### FR-FRM-011: Select Field

**Description:** Dropdown selection.

**Configuration:**
- required: boolean
- options: array of strings

**Acceptance Criteria:**
- [ ] Dropdown rendered
- [ ] Options populated
- [ ] Selection required if configured

---

#### FR-FRM-012: Radio Field

**Description:** Single selection radio buttons.

**Configuration:**
- required: boolean
- options: array of strings

**Acceptance Criteria:**
- [ ] Radio buttons rendered
- [ ] Only one selection allowed
- [ ] Required validation works

---

#### FR-FRM-013: Checkbox Field

**Description:** Multiple selection checkboxes.

**Configuration:**
- required: boolean
- options: array of strings
- min_selected: number (optional)
- max_selected: number (optional)

**Acceptance Criteria:**
- [ ] Checkboxes rendered
- [ ] Multiple selections allowed
- [ ] Min/max selected enforced

---

#### FR-FRM-014: Date Field

**Description:** Date picker input.

**Configuration:**
- required: boolean

**Validation:**
- Valid date format

**Acceptance Criteria:**
- [ ] Date picker rendered
- [ ] Date selection works
- [ ] Valid format required

---

### 2.3 Form Submission

#### FR-FRM-015: Submit Form

**Description:** Submit form data to database.

**Data:**
- form_id
- Field values (from form_fields)
- Submitter info (email, name, debtor_no if available)
- submitted_at (auto timestamp)

**Validation:**
1. Form exists and is active
2. All required fields present
3. All field values valid
4. debtor_no resolved if submitter known

**Acceptance Criteria:**
- [ ] Valid submission stored
- [ ] Submission linked to form
- [ ] Timestamp recorded
- [ ] Success confirmation shown

---

#### FR-FRM-016: Reject Invalid Submission

**Description:** Reject submission with validation errors.

**Error Response:**
- List of invalid fields
- Error messages per field
- Form data preserved for correction

**Acceptance Criteria:**
- [ ] Error messages clear
- [ ] Invalid fields highlighted
- [ ] Data preserved for retry

---

#### FR-FRM-017: View Submissions

**Description:** Display form submissions.

**Columns:**
- ID
- Form Name
- Submitter
- Submitted Date
- Status (new/read)

**Filters:**
- Form
- Date range
- Submitter email

**Acceptance Criteria:**
- [ ] Submissions listed
- [ ] Filters work correctly
- [ ] Pagination works

---

#### FR-FRM-018: View Submission Details

**Description:** Display full submission data.

**Displayed:**
- All submitted field values
- Submitter information
- Form metadata
- Linked customer (if any)

**Acceptance Criteria:**
- [ ] All fields displayed
- [ ] Customer link shown
- [ ] Timestamp shown

---

#### FR-FRM-019: Delete Submission

**Description:** Remove submission from database.

**Business Rules:**
- Soft delete (mark as deleted) or hard delete
- Audit trail if soft delete

**Acceptance Criteria:**
- [ ] Submission removed
- [ ] Associated data handled
- [ ] Removal logged

---

### 2.4 CRM Integration

#### FR-FRM-020: Link Submission to Customer

**Description:** Associate submission with CRM customer.

**Linking Methods:**
1. Submitter email matches debtor email
2. debtor_no provided in form
3. Manual link by admin

**Acceptance Criteria:**
- [ ] Link established when possible
- [ ] debtor_no populated
- [ ] Customer history viewable

---

#### FR-FRM-021: Customer Submission History

**Description:** View all submissions from a customer.

**Access:**
- Via CRM customer record
- Filter by debtor_no

**Acceptance Criteria:**
- [ ] All customer submissions shown
- [ ] Form type filter available
- [ ] Date range filter available

---

### 2.5 Export

#### FR-FRM-022: Export Submissions to CSV

**Description:** Export submission data to CSV file.

**Options:**
- All submissions
- Filtered submissions
- All fields or selected fields

**Acceptance Criteria:**
- [ ] CSV file generated
- [ ] Proper escaping
- [ ] Headers included

---

## 3. Non-Functional Requirements

### 3.1 Performance

| Metric | Target |
|--------|--------|
| Form load | < 1s |
| Submission save | < 500ms |
| List view load | < 1s |

### 3.2 Data Integrity

- JSON field definitions validated
- Required fields enforced
- Email format validated
- FK constraints maintained

---

## 4. Requirements Traceability

| Requirement ID | Priority | Status |
|----------------|----------|--------|
| FR-FRM-001 to FR-FRM-005 | Critical | Pending |
| FR-FRM-006 to FR-FRM-014 | High | Pending |
| FR-FRM-015 to FR-FRM-019 | Critical | Pending |
| FR-FRM-020 to FR-FRM-022 | Medium | Pending |