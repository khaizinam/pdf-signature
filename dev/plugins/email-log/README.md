# Email Log for Laravel CMS

Email Log for Laravel CMS allows you to log all emails sent from the system. You can view the email's envelope, headers, body of the email, and the SMTP server's response.

![Screenshot](https://github.com/FriendsOfCore/email-log/assets/114894084/bb823256-9859-4550-9efa-cb1d0f1360f8)

## Installation

### Install via Marketplace

- Go to **Admin Panel** -> **Plugins** -> **Add New**, find the plugin and click **Install Now** button.

### Install from source

- Download the package from [Laravel Marketplace](https://marketplace.fsofts.com/products/dev/email-log).
- Extract the package to your plugins folder (`dev/plugins`).

### Usage

Go to **Admin Panel** -> **Plugins** -> **Email Log** and press **Activate** button.

All emails sent from the system will be logged automatically, you can view the log by clicking on the **Email Logs** menu item.

You can customize how many days you want to keep the email log by updating the `Keep email log for days` setting in **General Settings**.

Then you can run the command to delete old email logs:

```bash
php artisan model:prune --model="FriendsOfDev\EmailLog\Models\EmailLog"
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email datlechin@gmail.com instead of using the issue tracker.

## Credits

-   [Developer Team](https://cms.fsofts.com)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
