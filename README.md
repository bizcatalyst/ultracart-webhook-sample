# Getting Started #

There are UltraCart steps needed to make this sample work.

1. Generate a REST API Key.  See https://ultracart.atlassian.net/wiki/spaces/ucdoc/pages/38688545/API+Simple+Key
2. Configure the webhook in the UltraCart backend.  You'll need your publicly visible url once the app is deployed, so you may wish to deploy this sample in digital ocean first and then configure the webhook once you have the url for the webhook script.
https://ultracart.atlassian.net/wiki/spaces/ucdoc/pages/2236448769/PHP+SDK+Sample+Webhook+that+uses+REST+API+to+process+order


These steps will get this sample application running for you using DigitalOcean.

**Note: Following these steps will result in charges for the use of DigitalOcean services**

## Requirements

* You need a DigitalOcean account. If you don't already have one, you can sign up at https://cloud.digitalocean.com/registrations/new

## Forking the Sample App Source Code

To use all the features of App Platform, you need to be running against your own copy of this application. To make a copy, click the Fork button above and follow the on-screen instructions. In this case, you'll be forking this repo as a starting point for your own app (see [Github documentation](https://docs.github.com/en/github/getting-started-with-github/fork-a-repo) to learn more about forking repos.

After forking the repo, you should now be viewing this README in your own github org (e.g. `https://github.com/<your-org>/sample-php`)

## Deploying the App ##

1. Visit https://cloud.digitalocean.com/apps (if you're not logged in, you may see an error message. Visit https://cloud.digitalocean.com/login directly and authenticate, then try again)
1. Click "Launch App" or "Create App"
1. Choose GitHub and authenticate with your GitHub credentials.
1. Under Repository, choose this repository (e.g. `<your-org>/sample-php`)
1. On the next two screens, leave all the defaults unchanged except for the Environment Variables.  Edit the Environment Variables and add a variable named **API_KEY** and paste your UltraCart Rest API key as the value.  Check the Encrypt checkbox.
1. Click "Launch App"
1. You should see a "Building..." progress indicator. And you can click "Deployments"→"Details" to see more details of the build.
1. It can currently take 5-6 minutes to build this app, so please be patient. Live build logs are coming soon to provide much more feedback during deployments.
1. Once the build completes successfully, click the "Live App" link in the header and you should see your running application in a new tab

## Making Changes to Your App ##

As long as you left the default Autodeploy option enabled when you first launched this app, you can now make code changes and see them automatically reflected in your live application. During these automatic deployments, your application will never pause or stop serving request because the App Platform offers zero-downtime deployments.

## Learn More ##

You can learn more about the App Platform and how to manage and update your application at https://www.digitalocean.com/docs/apps/.


## Deleting the App #

When you no longer need this sample application running live, you can delete it by following these steps:
1. Visit the Apps control panel at https://cloud.digitalocean.com/apps
1. Navigate to the sample-php app
1. Choose "Settings"->"Destroy"

This will delete the app and destroy any underlying DigitalOcean resources

**Note: If you don't delete your app, charges for the use of DigitalOcean services will continue to accrue.**




For reference, this is our app yaml that we used in our deployment at Digital Ocean.
```yaml
name: ultracart-sdk
region: nyc
services:
- environment_slug: php
  git:
    branch: master
    repo_clone_url: https://github.com/UltraCart/ultracart-webhook-sample.git
  http_port: 8080
  instance_count: 1
  instance_size_slug: basic-xs
  name: ultracart-sdk
  routes:
  - path: /
  run_command: heroku-php-apache2
  source_dir: /
```

