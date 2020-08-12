<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Validator;

class ListsController extends Controller
{
    private $mailchimp;
    public function __construct()
    {
        $this->mailchimp = new \MailchimpMarketing\ApiClient();
        $this->mailchimp->setConfig([
            'apiKey' => config('apikey'),
            'server' => config('server_prefix')
        ]);
    }
    /**
     * Show the list from the Mailchimp account.
     *
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAudiences()
    {
        $lists = $this->mailchimp->lists->getAllLists();
        return $this->successfulResponse($lists);
    }

    /**
     * Create new audience to the list
     *
     * @param  \Illuminate\Http\Request  $request
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAudience(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'address1' => 'required',
            'zip' => 'required',
            'country' => 'required'
        ]);

        if($validator->fails()){
            return $this->errorResponse([
                'message' => 'Invalid payload.',
                'errors' => $validator->errors()->toArray()
            ]);     
        }

        $payLoad = [
            'name' => $input['name'],
            'permission_reminder' => $input['permission_reminder'],
            'email_type_option' => false,
            'contact' => [
                'company' => $input['company'],
                'address1' => $input['address1'],
                'city' => $input['city'],
                'state' => $input['state'],
                'zip' => $input['zip'],
                'country' => $input['country'],
            ],
            'campaign_defaults' => [
                'from_name' => $input['from_name'],
                'from_email' => $input['email'],
                'subject' => $input['subject'],
                'language' => $input['language'],
            ],
        ];

        $lists = $this->mailchimp->lists->createList($payLoad);
        return $this->successfulResponse($lists);
    }

    /**
     * Update an audience from the list
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * 
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAudience(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'address1' => 'required',
            'zip' => 'required',
            'country' => 'required'
        ]);

        if($validator->fails()){
            return $this->errorResponse([
                'message' => 'Invalid payload.',
                'errors' => $validator->errors()->toArray()
            ]);       
        }

        $payLoad = [
            'name' => $input['name'],
            'permission_reminder' => $input['permission_reminder'],
            'email_type_option' => false,
            'contact' => [
                'company' => $input['company'],
                'address1' => $input['address1'],
                'city' => $input['city'],
                'state' => $input['state'],
                'zip' => $input['zip'],
                'country' => $input['country'],
            ],
            'campaign_defaults' => [
                'from_name' => $input['from_name'],
                'from_email' => $input['email'],
                'subject' => $input['subject'],
                'language' => $input['language'],
            ],
        ];

        $lists = $this->mailchimp->lists->updateList($id, $payLoad);
        return $this->successfulResponse($lists);
    }

    /**
     * Delete an audience from the list
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * 
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAudience(Request $request, $id)
    {
        $lists = $this->mailchimp->lists->deleteList($id);
        return $this->successfulResponse($lists);
    }

    /**
     * Show members from the Mailchimp account.
     *
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function showMembers($id, $members)
    {
        $members = $this->mailchimp->lists->getListMembersInfo($id);
        return $this->successfulResponse($members);
    }

    /**
     * Create new member to a specific list
     *
     * @param  \Illuminate\Http\Request  $request
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMember(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required'
        ]);

        if($validator->fails()){
            return $this->errorResponse([
                'message' => 'Invalid payload.',
                'errors' => $validator->errors()->toArray()
            ]);       
        }

        $payLoad = [
            "email_address" => $input['email'],
            "status" => "pending",
        ];

        $members = $this->mailchimp->lists->addListMember($payLoad);
        return $this->successfulResponse($members);
    }

    /**
     * Update a member from a specific list
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * 
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMember(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subscriber_hash' => 'required'
        ]);

        if($validator->fails()){
            return $this->errorResponse([
                'message' => 'Invalid payload.',
                'errors' => $validator->errors()->toArray()
            ]);       
        }

        $payLoad = [];

        $members = $this->mailchimp->lists->updateListMember($id, $input['subscriber_hash'], $payLoad);
        return $this->successfulResponse($members);
    }

    /**
     * Delete a member from a specific list
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * 
     * @author Joseph Ian Farillas <jfarillas.dev@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMember(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subscriber_hash' => 'required'
        ]);

        if($validator->fails()){
            return $this->errorResponse([
                'message' => 'Invalid payload.',
                'errors' => $validator->errors()->toArray()
            ]);        
        }

        $members = $this->mailchimp->lists->deleteListMemberPermanent($id, $input['subscriber_hash']);
        return $this->successfulResponse($members);
    }
}