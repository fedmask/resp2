<?php

namespace Tests\Unit;

use App\Models\CurrentUser\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    var $existingUserId = 'Janitor Jan';
    var $existingUserPassword = 'test1234';
    var $existingUserEmail = 'spanulis@hotmail.it';

    var $usernameDBField = 'utente_nome';
    var $emailDBField = 'utente_email';

    var $usernameForm = 'username';
    var $emailForm = 'email';
    var $email2Form = 'confirmEmail';
    var $passwordForm = 'password';
    var $password2Form = 'confirmPassword';
    var $surnameForm = 'surname';
    var $nameForm = 'name';
    var $genderForm = 'gender';
    var $cfForm = 'CF';
    var $birthCityForm = 'birthCity';
    var $birthDateForm = 'birthDate';
    var $livingCityForm = 'livingCity';
    var $addressForm = 'address';
    var $telephoneForm = 'telephone';
    var $bloodTypeForm = 'bloodType';
    var $maritalStatusForm = 'maritalStatus';
    var $shareDataForm = 'shareData';
    var $acceptTermsForm = 'acceptInfo';
    var $acceptConsentsForms = 'acceptCons';
    var $cpRegistrationNumberForm = 'numOrdine';
    var $cpRegistrationCityForm = 'registrationCity';
    var $capForm = 'capSedePF';

    var $loggedUserRedirect = '/home';
    var $landingPage = '/';

    var $patientRegistrationUri = '/register/patient';
    var $patientRegistrationView = 'auth.register-patient';

    var $careProviderRegistrationUri = '/register/careprovider';
    var $careProviderRegistrationView = 'auth.register-careprovider';

    var $newPatient;
    var $newCareProvider;

    /**
     * Instantiates the resources before each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->newPatient = [
            $this->usernameForm => 'Tizio',
            $this->emailForm => 'tizio@gmail.com',
            $this->email2Form => 'tizio@gmail.com',
            $this->passwordForm => 'test1234',
            $this->password2Form => 'test1234',
            $this->surnameForm => 'Verdi',
            $this->nameForm => 'Stefano',
            $this->genderForm => 'male',
            $this->cfForm => 'vrdsfn80c30f205z',
            $this->birthCityForm => 'Milano',
            $this->birthDateForm => '30-03-1980',
            $this->livingCityForm => 'Milano',
            $this->addressForm => 'via mazzini 10',
            $this->telephoneForm => '3331234567',
            $this->bloodTypeForm => 'A_POS',
            $this->maritalStatusForm => 'D',
            $this->shareDataForm => 'Y',
            $this->acceptTermsForm => 'on',
            $this->acceptConsentsForms => 'on'
        ];

        $this->newCareProvider = [
            $this->usernameForm => 'Caio',
            $this->emailForm => 'caio@gmail.com',
            $this->email2Form => 'caio@gmail.com',
            $this->passwordForm => 'test1234',
            $this->password2Form => 'test1234',
            $this->cpRegistrationNumberForm => '12345678',
            $this->cpRegistrationCityForm => 'Taranto',
            $this->surnameForm => 'Bianchi',
            $this->nameForm => 'Luca',
            $this->genderForm => 'male',
            $this->cfForm => 'bnclcu85b28l049g',
            $this->birthCityForm => 'Taranto',
            $this->birthDateForm => '28-02-1985',
            $this->livingCityForm => 'Taranto',
            $this->addressForm => 'via cesare battisti 40',
            $this->capForm => '74121',
            $this->telephoneForm => '3123456789',
            $this->acceptTermsForm => 'on'
        ];
    }

    /**
     * Deletes the changes after each test
     */
    public function tearDown()
    {
        User::where($this->usernameDBField, $this->newPatient[$this->usernameForm])->delete();
        User::where($this->usernameDBField, $this->newCareProvider[$this->usernameForm])->delete();
    }

    /**
     * Checks if the registration of a new patient performs successfully
     */
    public function testRegisterPatient() {
        //Visit patient registration view
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertViewIs($this->patientRegistrationView);

        //Send valid data via POST, register the user, go to /home
        $response = $this->call('POST', $this->patientRegistrationUri, $this->newPatient);
        $response->assertRedirect($this->loggedUserRedirect);
    }

    /**
     * Checks if the registration of a new care provider performs successfully
     */
    public function testRegisterCareProvider() {

        //Visit patient registration view
        $response = $this->call('GET', $this->careProviderRegistrationUri);
        $response->assertViewIs($this->careProviderRegistrationView);

        //Send valid data via POST, register the user, go to /home
        $response = $this->call('POST', $this->careProviderRegistrationUri, $this->newCareProvider);
        $response->assertRedirect($this->loggedUserRedirect);
    }

    /**
     * Checks whether a logged-in user is successfully blocked from registering a new account while logged-in
     */
    public function testLoggedUserRedirect() {

        //Perform a login
        $this->login($this->existingUserId, $this->existingUserPassword);

        //Check redirect when visiting patient registration
        $response = $this->call('GET', $this->patientRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);

        //Check redirect when visiting care-provider registration
        $response = $this->call('GET', $this->careProviderRegistrationUri);
        $response->assertRedirect($this->loggedUserRedirect);
    }

    //-------------- Patient validation methods --------------

    /**
     * Checks if the patient registration stops in case of errors with the username
     */
    public function testPatientUsernameValidation()
    {
        //Checks for errors with missing username
        $wrongData = $this->newPatient;
        unset($wrongData[$this->usernameForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with already existing username
        $wrongData = $this->newPatient;
        $wrongData[$this->usernameForm] = $this->existingUserId;
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the email
     */
    public function testPatientEmailValidation()
    {
        //Checks for errors with missing email
        $wrongData = $this->newPatient;
        unset($wrongData[$this->emailForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with email format
        $wrongData = $this->newPatient;
        $wrongData[$this->emailForm] = 'wrong';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with mail confirmation
        $wrongData = $this->newPatient;
        $wrongData[$this->email2Form] = 'wrong@wrong.com';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with already existing email
        $wrongData = $this->newPatient;
        $wrongData[$this->email2Form] = $this->existingUserId;
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the password
     */

    public function testPatientPasswordValidation()
    {
        //Checks for errors with missing password
        $wrongData = $this->newPatient;
        unset($wrongData[$this->passwordForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with password format
        $wrongData = $this->newPatient;
        $wrongData[$this->passwordForm] = 'wrong'; //too short
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with password confirmation
        $wrongData = $this->newPatient;
        $wrongData[$this->password2Form] = 'wrong';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the surname
     */
    public function testPatientSurnameValidation()
    {
        //Checks for errors with missing surname
        $wrongData = $this->newPatient;
        unset($wrongData[$this->surnameForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the name
     */
    public function testPatientNameValidation()
    {
        //Checks for errors with missing name
        $wrongData = $this->newPatient;
        unset($wrongData[$this->nameForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the gender
     */
    public function testPatientGenderValidation()
    {
        //Checks for errors with missing gender
        $wrongData = $this->newPatient;
        unset($wrongData[$this->genderForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the fiscal code
     */
    public function testPatientFiscalCodeValidation()
    {
        //Checks for errors with missing fiscal code
        $wrongData = $this->newPatient;
        unset($wrongData[$this->cfForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with fiscal code format
        $wrongData = $this->newPatient;
        $wrongData[$this->cfForm] = 'wrong';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the birth city
     */
    public function testPatientBirthCityValidation()
    {
        //Checks for errors with missing birth city
        $wrongData = $this->newPatient;
        unset($wrongData[$this->birthCityForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the birth date
     */
    public function testPatientBirthDateValidation()
    {
        //Checks for errors with missing birth date
        $wrongData = $this->newPatient;
        unset($wrongData[$this->birthDateForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with birth date format
        $wrongData = $this->newPatient;
        $wrongData[$this->birthDateForm] = '1980-01-01';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the living city
     */
    public function testPatientLivingCityValidation()
    {
        //Checks for errors with missing living city
        $wrongData = $this->newPatient;
        unset($wrongData[$this->livingCityForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the address
     */
    public function testPatientAddressValidation()
    {
        //Checks for errors with missing address
        $wrongData = $this->newPatient;
        unset($wrongData[$this->addressForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the phone number
     */
    public function testPatientTelephoneValidation()
    {
        //Checks for errors with missing phone number
        $wrongData = $this->newPatient;
        unset($wrongData[$this->telephoneForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page

        //Checks for errors with phone number format
        $wrongData = $this->newPatient;
        $wrongData[$this->telephoneForm] = 'wrong number';
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the bloodtype
     */
    public function testPatientBloodTypeValidation()
    {
        //Checks for errors with missing blood type
        $wrongData = $this->newPatient;
        unset($wrongData[$this->bloodTypeForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the marital status
     */
    public function testPatientMaritalStatusValidation()
    {
        //Checks for errors with missing marital status
        $wrongData = $this->newPatient;
        unset($wrongData[$this->maritalStatusForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the patient registration stops in case of errors with the acceptance terms
     */
    public function testPatientTermsValidation()
    {
        //Checks for errors with missing terms acceptance
        $wrongData = $this->newPatient;
        unset($wrongData[$this->acceptTermsForm]);
        $this->call('GET', $this->patientRegistrationUri);
        $response = $this->call('POST', $this->patientRegistrationUri, $wrongData);
        $response->assertRedirect($this->patientRegistrationUri); //Goes back to registration page
    }

    //-------------- Care provider validation methods --------------

    /**
     * Checks if the care provider registration stops in case of errors with the username
     */
    public function testCareProviderUsernameValidation()
    {
        //Checks for errors with missing username
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->usernameForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with already existing username
        $wrongData = $this->newCareProvider;
        $wrongData[$this->usernameForm] = $this->existingUserId;
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the email
     */
    public function testCareProviderEmailValidation()
    {
        //Checks for errors with missing email
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->emailForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with email format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->emailForm] = 'wrong';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with mail confirmation
        $wrongData = $this->newCareProvider;
        $wrongData[$this->email2Form] = 'wrong@wrong.com';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with already existing email
        $wrongData = $this->newCareProvider;
        $wrongData[$this->email2Form] = $this->existingUserId;
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the password
     */

    public function testCareProviderPasswordValidation()
    {
        //Checks for errors with missing password
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->passwordForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with password format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->passwordForm] = 'wrong'; //too short
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with password confirmation
        $wrongData = $this->newCareProvider;
        $wrongData[$this->password2Form] = 'wrong';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the registration number
     */
    public function testCareProviderRegistrationNumberValidation()
    {
        //Checks for errors with missing registration number
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->cpRegistrationNumberForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with registration number format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->cpRegistrationNumberForm] = 'wrong'; //too short
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the registration number
     */
    public function testCareProviderRegistrationCityValidation()
    {
        //Checks for errors with missing registration number
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->cpRegistrationCityForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the surname
     */
    public function testCareProviderSurnameValidation()
    {
        //Checks for errors with missing surname
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->surnameForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the name
     */
    public function testCareProviderNameValidation()
    {
        //Checks for errors with missing name
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->nameForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the gender
     */
    public function testCareProviderGenderValidation()
    {
        //Checks for errors with missing gender
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->genderForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the fiscal code
     */
    public function testCareProviderFiscalCodeValidation()
    {
        //Checks for errors with missing fiscal code
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->cfForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with fiscal code format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->cfForm] = 'wrong';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the birth city
     */
    public function testCareProviderBirthCityValidation()
    {
        //Checks for errors with missing birth city
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->birthCityForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the birth date
     */
    public function testCareProviderBirthDateValidation()
    {
        //Checks for errors with missing birth date
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->birthDateForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with birth date format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->birthDateForm] = '1980-01-01';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the living city
     */
    public function testCareProviderLivingCityValidation()
    {
        //Checks for errors with missing living city
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->livingCityForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the address
     */
    public function testCareProviderAddressValidation()
    {
        //Checks for errors with missing address
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->addressForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the postal code
     */
    public function testCareProviderCapValidation()
    {
        //Checks for errors with cap format (too short)
        $wrongData = $this->newCareProvider;
        $wrongData[$this->capForm] = '1234';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with cap format (too long)
        $wrongData = $this->newCareProvider;
        $wrongData[$this->capForm] = '123456';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with cap format (has text)
        $wrongData = $this->newCareProvider;
        $wrongData[$this->capForm] = 'wrong';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the phone number
     */
    public function testCareProviderTelephoneValidation()
    {
        //Checks for errors with missing phone number
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->telephoneForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page

        //Checks for errors with phone number format
        $wrongData = $this->newCareProvider;
        $wrongData[$this->telephoneForm] = 'wrong number';
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }

    /**
     * Checks if the care provider registration stops in case of errors with the acceptance terms
     */
    public function testCareProviderTermsValidation()
    {
        //Checks for errors with missing terms acceptance
        $wrongData = $this->newCareProvider;
        unset($wrongData[$this->acceptTermsForm]);
        $this->call('GET', $this->careProviderRegistrationUri);
        $response = $this->call('POST', $this->careProviderRegistrationUri, $wrongData);
        $response->assertRedirect($this->careProviderRegistrationUri); //Goes back to registration page
    }
}
