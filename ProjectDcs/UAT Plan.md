# ksf_FA_Forms - UAT Plan Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Pending UAT

---

## 1. Introduction

### 1.1 Purpose

User acceptance testing for the FA_Forms module.

### 1.2 UAT Objectives

1. Validate form creation and management works
2. Verify field validation is accurate
3. Confirm submissions are stored correctly
4. Ensure CRM integration functions properly

---

## 2. UAT Scenarios

### 2.1 Admin Scenarios

**UAT-FRM-ADMIN-001: Create Contact Form**
```
Objective: Create a customer contact form

Test Steps:
1. Log in as Admin
2. Navigate to CRM > Form Builder
3. Create new form:
   - Name: "Customer Contact"
   - Fields:
     * name (text, required)
     * email (email, required)
     * phone (phone, optional)
     * subject (select, required)
       Options: [Sales, Support, General]
     * message (textarea, required)
4. Save form
5. Activate form
6. Test form submission
```

**Success Criteria:**
- [ ] Form created with all fields
- [ ] Field validation works
- [ ] Submission stored correctly

**Sign-off:** Admin _______________ Date: ________

---

**UAT-FRM-ADMIN-002: Create Feedback Survey**
```
Objective: Create customer feedback survey

Test Steps:
1. Create survey form:
   - Name: "Customer Feedback"
   - Fields:
     * customer_name (text)
     * email (email)
     * overall_rating (radio: Excellent, Good, Fair, Poor)
     * would_recommend (checkbox: Yes, No)
     * comments (textarea)
2. Activate form
3. Submit test response
4. Verify submission stored
```

**Success Criteria:**
- [ ] Radio field works
- [ ] Checkbox field works
- [ ] All responses stored

**Sign-off:** Admin _______________ Date: ________

---

**UAT-FRM-ADMIN-003: Manage Submissions**
```
Objective: View and manage form submissions

Test Steps:
1. Navigate to CRM > Submissions
2. View all submissions
3. Filter by form type
4. View submission details
5. Export to CSV
```

**Success Criteria:**
- [ ] Submissions listed
- [ ] Filters work
- [ ] Export successful

**Sign-off:** Admin _______________ Date: ________

---

### 2.2 Customer Scenarios

**UAT-FRM-CUST-001: Submit Contact Form**
```
Objective: Customer submits contact request

Test Steps:
1. Access contact form (as customer)
2. Fill form:
   - Name: "Michael Johnson"
   - Email: "michael.j@company.com"
   - Phone: "555-987-6543"
   - Subject: "Support"
   - Message: "I need help with my order #12345"
3. Submit form
4. Verify success message
5. Verify email notification (if configured)
```

**Success Criteria:**
- [ ] Form validates input
- [ ] Submission stored
- [ ] Success message shown

**Sign-off:** Customer Representative _______________ Date: ________

---

**UAT-FRM-CUST-002: Validation Errors**
```
Objective: System shows clear validation errors

Test Steps:
1. Access form
2. Try to submit without required fields
3. Verify error messages shown
4. Fill one required field
5. Verify that field passes validation

Expected: Clear, field-specific error messages
```

**Success Criteria:**
- [ ] Errors clearly shown
- [ ] Invalid fields highlighted
- [ ] Valid fields clear of errors

**Sign-off:** Customer Representative _______________ Date: ________

---

### 2.3 CRM Integration Scenarios

**UAT-FRM-CRM-001: Auto-Link Customer**
```
Objective: Submission auto-links to existing customer

Test Data:
- Customer "Acme Corp" with email: contact@acme.com

Test Steps:
1. Submit form with email: contact@acme.com
2. Verify submission linked to Acme Corp
3. View customer record
4. Verify submission appears in history
```

**Success Criteria:**
- [ ] Customer auto-linked
- [ ] debtor_no populated
- [ ] History viewable from CRM

**Sign-off:** CRM Manager _______________ Date: ________

---

**UAT-FRM-CRM-002: View Customer Form History**
```
Objective: View all forms submitted by customer

Test Steps:
1. Open customer record
2. Navigate to Submissions tab
3. View all submissions
4. Filter by form type
5. Click to view details

Success Criteria:
- [ ] All submissions shown
- [ ] Form type filter works
- [ ] Details viewable

**Sign-off:** CRM Manager _______________ Date: ________

---

## 3. Success Criteria

| Criteria | Threshold |
|----------|-----------|
| All scenarios executed | 100% |
| Critical defects resolved | 0 open |
| Business approval obtained | Yes |

---

## 4. Sign-off Section

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Admin | | | |
| CRM Manager | | | |
| IT Manager | | | |
| UAT Lead | | | |