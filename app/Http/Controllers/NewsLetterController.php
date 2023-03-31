<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;

//use Newsletter;
//use Spatie\Newsletter\Facades\Newsletter;

class NewsLetterController extends Controller
{
    public function index()
    {
        return view('newsletter');
    }

    public function store(Request $request)
    {
        if ( ! Newsletter::isSubscribed($request->email) ) 
        {
            //Newsletter::subscribePending($request->email);
            Newsletter::subscribe($request->email);
            //Newsletter::getMembers();
            return redirect('newsletter')->with('success', 'You are subscibed successfully.');
        }
        return redirect('newsletter')->with('failure', 'Sorry! You have already subscribed.');
            
    }

    public function showStats()
    {
        $stats = Newsletter::getStats();
        $sent = $stats['sent'];
        $failed = $stats['failed'];
        return compact('sent', 'failed');
        //return view('newsletter-stats', compact('sent', 'failed'));
    }

    public function sendEmailToSubscribers(Request $request)
    {
        $api = Newsletter::getApi();
        
        //$subscribers = Subscriber::all();
        $subscribers = Newsletter::getMembers();
        //return $subscribers['members'];
        foreach ($subscribers['members'] as $subscriber) {
            $name = $subscriber['full_name'];
            $content = 'Hey there this is an email';
            print_r($subscriber['email_address']);

            $subject = 'General Email for all users';
            $title = 'Welcome Guys';
            $body = 'I am sending this email to you as a welcome note.';
            $ctaUrl = '#';
            $ctaText = 'Click me';
            
            $campaignId = $api->post("campaigns", [
                'type' => 'regular',
                'recipients' => [
                    'list_id' => env('MAILCHIMP_LIST_ID'),
                ],
                'settings' => [
                    'subject_line' => $subject,
                    'title' => $title,
                    'reply_to' => 'arqamsaleem@gmail.com',
                    'from_name' => 'Arqam',
                ],
            ])['id'];
            print_r($campaignId);
            //return;
            $api->put("campaigns/$campaignId/content", [
                'html' => view('emails.emailDemo', compact('title', 'body', 'ctaUrl', 'ctaText'))->render(),
            ]);
            
            $api->post("campaigns/$campaignId/actions/send");
            //Newsletter::sync();

            return redirect()->back()->with('success', 'Your email has been sent!');

            //Newsletter::subscribe($subscriber->email, ['name' => $subscriber->name]);
            //Newsletter::send([$subscriber['email_address']], 'emailDemo', compact('name', 'content'));
            
        }
        return;
        return redirect()->back();
    }
}
