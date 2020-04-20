# MailHog

MailHog is a SMTP server used in local development to catch all
emails sent from your app. It works by setting the `MAILER_DSN` 
and `MAILER_URL` to: `smtp://mailhog:1025` on your `.env` file.

You can access to the MailHog Inbox here: `http://mailhog:8025`

Using the Inbox you can view all the emails sent by the App, and it also
allows to resend the mail to a public email addres by configuring one SMTP
server. To do that you need to know (this is an example):

Server: smtp.gmail.com 
User: test@gmail.com
Pass: ___ (your password)

This is useful to resend some emails to Litmus in order to do a cross browser
testing.
