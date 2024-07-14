<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventNote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('[DevSeeder] Start.');
        $CURRENTTIME = Carbon::now();

        // EVENTS
        $eventGodotCon2024 = Event::create([
            'id' => 'e5509f81-9247-45bb-b7b7-e3723d890826',
            'logo' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALIAAABkCAMAAAAVM5poAAABpFBMVEVHcEz////////////////////////+/v7///////////////////////////////////////////////////////////////////////////////////////////8AhP8AAABe9wD/AJlCrACzAGv///+AAE0AW7IDAwQFCAgAhv8AXrZDrwBRUVFg+gEQEA8YGBhYADQoKCj29vYAFCcAffEAgPgRAAoACxZJSUkAeOggICAJFwD3AJTOAHsAJEYAQX8AHDcAa9AlYQAAU6IALVgiABQANmlAqQAAZMJCQkIAS5HqAIwPKAA1NTVFACk0iADu7u4vfQAAct2/AHI0AB87Ozvn5+elAGOcAF1zAEXX19ff39+OAFVnAD4vLy+Ojo47mgDdAIUqbgBZWVlIvAEdTQCXl5etAGhY6AAWOgB2dnZd8wC7u7s+ogBV3wA4kgFqamphYWHFxcVQ0wDPz89b7gC0tLSHh4eenp58fHxLxgCtra1wcHCBgYGjo6OoqKirq6upqamnp6empqYAh/9+sl4AiP+Wwnui1IMAHvZHcExiQQ0DAAAAjHRSTlMAE/S+BQxI/ereyLKIIRvRnaY7lVQyXH4sJndjb2hr////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AKYUz0cAABbgSURBVHjazJnZTypBFsYFxQbccEe991LGVOhGlp5uISAkCMKgEDqiCTxIAgaQoCBuuOHu3MnMfz2neoEWW703zoPnQaBo4Fdff3XOqbKv7+9DZ52an51QDRhGdH3fNwasC5Nmox5j40xnBjP9JrNlYdrwLYHnfg0ZMcXn8rsZbJR0Hv1ppnLwEhvNkzPWb4Y9MGExYb5VLGc5lk22cP9oX9/I/BjOFQuscHLdymAKsAcHvg+xYVKPc9cBD0L+SDzuD/B4fHAWgKsFGFlhkEc4eWjxWD/8bZgHhnGmyCE6krDveG22FHONMYUzBBitRL3RWCLip9nsE9ZPfBfkX3r+BNHxZa/NYYPwRgp5jHMuRGLNYXM4bIAdp9ld/OObEA8a+UMaJXwiL8TvGH2D8QstItulUcBOoBc8+T2Ip038DS3KqYQ3zLZwVST27yiDjhSq4v5vkTZ0/fw9A3CJDrHNsUwLJ0lCTEe8yuDvFLrBptHvgDxDFQkxCvu6zL61Fb+fIc5Ys6lUPtFafwMG3ejInHV62mqdGxnVGeSkMjBgMOh0o6MjYozCG/+/GzSb50Q9V1ZtqljdiW7aY6lYR2SicpmiZlSsIxNTv4YtQ+Yxk8kohck01j/+U9dnmLEMDfWbyTtKjJn7LdOQ/4fHxy2Tw7PzP37OTA0OTkxMW+dgPn+aPEd+WIYHdZN5tse18nr77YCwqVUWMtisyGyYGjLp+Uxu9+zyX9Wrm8MTiLvD++L1Zb5/cJziMxmoo62zxuXt0+PL49Nl42yXN03M6nkIisIkKEqv10sTHZ/5k3swOm8iHxszZQQRmdl02D4KUJm54rFxeAR4R60WPX92GBCCrEe0VTcYrmrMVV1CgYP3PAxDS8EwbLllyhUDyUDAVS6fwvxu7q+K1euH50uoUtT4p6tkYMpMgMXZniJ1OnsvHDHAOYWEPTZsMZuMOH/qUSBD6XT64OAgnQ6FCD9zmkSawV26lKd09y9Ns64GxkOfdIyGYWjYMtflu11AvhI/vhK1fYy8moBfKFySSWYaxcszcnPog9LxRuW82azVLmq1ZrNdOdpOi1+X3l8vbW/tHUHsHW+X1sVRlob5icHQrybDQr39uEzpLKBwIwkf454p/ASPdPgTYmD2xVYQ8tzvtopZBjGuxzLNbNUW3W73YifghdtJlC4169IrKRYXm1shwlZqn5NoV5x7pZCauYHNhg+7IKjHh3BfI3E/c3cWgLWX8jpsn0c0Tr6dFW8pzd4fHtcX38bFAWjcdPeMuhePaXHcrUxtsQ3Kh7bITYAnLt449wHyPIXzwLmSWrVFwwjQw5u2PwqHN+UnvOFYLAIPrv+6NZDd2wita01lH6H9C/WFGzQqueUbw+7qpz/qKXAeFkg8KjmU8a/9kcRSbIb9YbvX4dghzhb+o8HsPtJGdm8B8qvbUjtAW+IXNNOIaegH389uZpwpE2KJ0xeN2v4mvFFpgqKzg/9+y+xuM9rIR73I9X0ZuZZG9BM19W56AyPfgxfsm3Jlc9j+LjrXg6kQW3nLdh7SRl6ie8fXZWRi/2s8864t9LjhQSuxZXvU9rVw7KxoWgBusyZy5Q1ySUEGmxfxr3cbN5zLInpt2W5f9n6R2QtrsKSJrDG6uPjWMAoyOATd49l3kK1GfAkJPQXIX5XZscmgUMX9xyq3ew0DuUVCBoegOzz8StrpQavcLM2JyCgOxPbl1a8xJ3qy1ifI4PHS+8inqi2PbsoyZtQbh6XiMmrCLcjEDHGGfdP3FeLVFcQ4NbJcU3v5vTUMpD0ZuQS1hBpXKt2CmaJ2b2/zeF56bcb5IJSDSIy4eecrvojRmiL3ZIxuWqv1qt9BJtUnwA9JRrAOUfiszAY9XMMoVpeBISx1m4mvyuyLI/rI/Zln2+sVVeXoQT5WIWd5aWM5OIZbJ2zwtFpGQm5IHJrEfEBs6ckK/Iqbo350UHtFIHVAdXXBBpiSqvnoQd5TkKEwFjJiXzRhzNwQ4KfHQxZdUQvixgnjE7F5CttVScPxeguiUT98Xq9PfQXsUtCeWuTa3jZEqbTPqKocIK+rit16bz3sInO5MdIxW/ChhwBfuZJ3XHDXRHqlBaVBRmQFyv2QLxqL2Td33k3Uq/a1cCQSX1OlRcca9GU99bgTWsj1RRVyvQ79dQ1Urtclh6BgnmzfDf181lME4MDhw9O95w5bYB5TlHKqEifOEM28EycNGuOPrGmuR18sInfk0EF1RgFZ9EVdbO5rF86Q1L6TdrmzLEG/9c4KXJemUq81ScMMsZXerrTbzdriHpT+XRNs0QbGKRcSXMLJw/Pj4/Np8CVn/vELNlBnno4zRDNHI539TUSjvPgSdHfvE1fc70iAyhfKj5PYO14iDXwFmvkDFXK3FSrB83rtvOJc2thYWnIuOTeO4BGeVcD+npbRKvr2GnkET/AQkJ+KLCNtg6QsB/0yMTPIukOIaS7LkZmEV9/0PynS158+3BZd5IKEr1NIQkvk15fkAASns3JeI2p21qUa2Q3I523n0ttwQl5mzsSGeYrKB2m4UdmX54c7juMQt0vBnpzPSsgxcf35yFbDU8zxuUYZlEzJ/UMqkZLoSfMTbJCp8rcwVzrmUJCZLa2fr5xvy5aRkS+6KqflCR7tvUVuiOc600beRXYdrperLCskCxwtBJJJ1410DCCmuU2SrBBTFeXnT5VTI5IPpKMicWf9gKUowpyUMy9Iy1takhGA9Hm9k8cklcEQ7XWUPhKv2DhI7/Ui07cU6fF1Y7iKXGXXSZINJoVCkmNYlvUou1tazMy+ZZqUHgmpwSgHXQniWzkzwGqWkcnJkl8+8ICbs/0ecmiv0j6HJXlRb25VLqTltuTsIB+lX8/WCV5GD2KPD6WuwRQCHMsJBS6bZD2CCyKQDHaz3PIqQb6XkaBjSigayoITvTvIsJwRveyQix8qaSNvo9AxeXRWpHBKlwFy6APkqnR6ZgGVGU4AYCHJebiASwzBI6UMsWbvQAuJDmWkO4RiHQ0lCxBjeFry+6Rw+qUdmA/2JOvvINOMRLQhWldZoARZ8sNGmt5+jQyyXeEFCfkUkAtCNgtKJyXgQJDhkiJzWGyad8DLnMR0ySoaqpDJlKoy8hnb8TJB3tdG3qI1Xa5GRm+R78XDl4F+qozYrMCxHWCXwDCCK8mISZhkuU0vocs2MvnLOwBiuhrKcNBjomROyhgF+FSiuyU5WHpHZU2XE+RjSf0DDeQ7sdecM2WyiPGwXFayRNmVZWk2Cdj/+KeSmJe9m6T0eQpB6Zi5q6GiJ5iZzhafn4vkX1ad40aCnN74H+vWwpRGloV9I2qiJrp5bM3mFsPjtmhBI8qj5SGBdkRGQmgUUB4hVqRiZSoxZRlTO6Z2KlPzt/ece/txu2ndTNWeSirBRvj649xzvvPgLshv3SEbDvPe/gQG+RMrS1Y851TS4aKVIUrHUimFditBjHK6Zi4mTXFg9LkQkBE8tvZ4t48/Q08la2mE/Jsrza/dvRwgGw7jBvmSQX582iOxDZ3gjSPgESmO0HbGNwCazQowrGfs5F76hcUhD3IMs9X0MxM2+ov+ObvkMjcvX39HjFP33n5PDPKGByqph4t9yNec5HIvSmkUvFghiU7G5/MFzWrqxYs/08VSPBkvhW3FszV1YG0WhyxCyO4hA6G5ePn6m18xLMJvrP/ihPyK5YYlEPi1MoFwvJGCeAFVtXK0kYpJpOH3oSHNLMqx3sDadrqeFvQwRl0pbD1OF/dyOZv4xDxOdl6tC2/N1dHPr3f4BdvtrK//9g57uK8/vnnz5q1EIP0Zz4B/4XPhkBdOFUlRolE4V1K0lwLAEZLoDnzcgoTmQmGwtGtbJV862LZr/O0XQhWwVmcHYOflR9ZDxjbym4+vXr99+fI9a8L++vYVXvmFG7Y33/OUi/oU/Wzn3cvXrxA//NrLHdQMs5Cw569Y+JVYxEgdgisnZM1nGNAs5fbyB8XCi7Ufb3Kt6fZXIUnZq+9gDx/N2eimO3p3n/f36WhXn0pWe5zeerD1MnkVkaJK7DCFniERqra1jM+yNv898OF86AdrwK16IRwqQgUTKuYgR5H/o50de0FjLB33JDZlAc9INNr+is9mWdX6hZwd8zZUelvgCQ7+D3aTSQh2OK7BUO4cidCEqjp+QhPcLI7VKlgjoV+vBlvNVqeLD8+wxP7J8xVrCZpodFtZB16LZuc8aru4V8pBpbeL5624v+U4ccKw4FJ4gO+hZQeDrvG42gY0fk3LMvO3+c3Q7iCT8WUyWZndYkv/1P0q1qtz42MPFq+iCbndaQ18rpZNWHSY86i1sDUVw/stmZjXQnZ/VC6s/1ezGdtrqv6M882q+HPZ+HEFHtKWebUDL8dK7AXPJe34/X4t4465S5K5XDwuoXY29wTyjjmexT+/IiWT8Xg8iaVK//eLr19usC3SMV4yw5DR5uibDRrwc7/5sCngZ3eqnC4+xDbnh0gVIOtenKlkNb8muEg2gdmkeBAXFwVKDg81rzDdIeX3C/V0Ol0vkd7x5OT88uNZJLtrviYqAdJwcUOfn5JEVgQp3BeELyixAfLU0maK0cyemW12gmidYcWiGdVcuCQsCrC8hzzGOZfmPJ5H4pw+V/kzRI6Wp6emxqbnvqLrmsFTQ++pun2slYYIeZAQHuA13hUYm5n4g+o0V4ZB0zoD81axOR7OU5IM1dNbGCJQ18XDaW77wL9U5P+vM3WUNx2bpFjfb3ru1u6keM4arp4oi5ArqggZ/ClyxVpD05O1owSjudIKCmacVE5zGKUcxOfdXGlvLy7uZvyVZ0sEnHEW8Y0kDsXK2SSDPMmaT5zmTKaC58rdMSBCWR8G8CpChtuJfGaNjLF/eM6JjDTbEAeDmo3m0C6xDZfNs7hWSNod21yBwPUM1qqcnuwTTnNlAEfF78fwpbrGqA6hmsCrDXKXSDrk8bnTWKLl93e6dsgdnYYMp9l+5AQ9xI6cYCb/EFhudch8pYd0NP8QycFon2gOjM9RcJEWoUOBVxvkIJH0dvLY88BXoHnYloPuNGtIc/jARmZc6MyFcP8FDf3G6MbwrsE5gzw1/wcP12rTz6wDkZkG/RoDPQjKlo8MiRgkujbIHSJd60uQD7wn0USrJcsOmk1vllnQODjIs5SXg5RXCjn2Xwr7YAU8nYI6zdFr3nZ/fBLVExuH3MTzVwX82qDSapDGQIxyHSG3tDANZiqZDA/T9N865LGFwCfS7ciy7O4ZnOZQuIDCgpu7ehtpiEdPlvRBop4F1ZYFmVQ7zVYbkkdDoBLiX1AgNgO+D86vaZgqNEr/MDaXVmc/R9Q2QG7bMRuQM5zmUOFvzSDW8iBj+PRlavlY10fycAgaR9bXQ1TUQg3NLhCslFNhZ9UwbZgg34wpNqSTM1KVnZ5hsqzT/Dcxp+PStUHKs8Urvf2kNlQ1QQQlAv6hmQcRIcsmYL/d4ATcmIP3RxMfpITspNmCbNAc2v/xwQmEuI3N5Slz9eCbJKzfWAGzyk5kdmBJJpYWMybgof4XgnCCnJuQp+c3N0jDSXPLCj4GzeDQPzoirscjH2atnbnnExcuop3KQx0XqFI8ZE1K1AqEb00AbBicgP7EijVovx6l2S8cA4NmOIX7PG3/r/nZHrncFPY/p5drqRHEia4ICc6Y1sCArdmQmg8A8hdrvWF6cjM14s1ievKz2MxBQwELAa1+P/IiVbggMFfu5q6cVZUR8zC5VNudZjPYICxgOyke8j8NcissDq54/iOpXRvNTVG3gCZJlg6w2g6ZBsjr23eN25O077GvIjyavVYcfmwxCTGEqip39KorxwzyVz7l0xcaamXSbgs0t+yyxQ8JS4KqtciaBCbsfXfXTu9ineZYa/vn7MnXVDlmHsBESwDW6TbMAkhuIacQDptNW8iokgvPT8Lreb7RRjNo0jx0CC1sw+BSVnK3lD/A+jnMobtihpAcOxldBJpZXvTWjm8M/6g6glgrWFWNSFhtNCAaqqrcshwDIP8ufnLjc7Uj8KJOu80UfjbjLMuE6MTEBKhQwO6+sVGP05vA0uhi6dT4g5l5z2fdP7r+EWtVbbU3atSmyPInj7jd96/AOXrRsAnhxillMy01ehixq08mjXeLbosxQHK5Nrt6585gn99+exQy+qvDhBuTySd9mUHf2lo87rGKalTHZmVJSW1E3eLqnlvza2uXfrcvqNjWwxZ1keTCMtelNmsMzSMok0sbZNCgfeZezlq7ElQjhxspxWwf20Qom2Q6SC5IsWPv07vXBvlQkcpukIPO9KgLVkTdJWf27aIHXpD6IzSDOKRAcRmIuewfRZ2okwcGy0L7METOPPd8i2Bm4pPr8XNnWbWcGSB77B/ek8Atexnh6A1AzeJYrQcCIXUcqF19v0j1lKiixHqHZfQV6cDw5eLevrUTfHvP3iBwc343ZHkkQ3aEaxsOyM+8Jwp7gt7SGAy7KpFinGKS0gd7m7VTsONabdODUxYdMjaQjJkqsNy/b6F0ap4P9dWhC2QWMpSjnnXYZVMcNUYgg9S/wCcMNZAlrXZVpXrLGVtFZ8eBgHdxIiAaJHlqQM7jtM9IfbR/7/centR6Dv6sKAeROfLldLP2oWylde4aTXlk7Qw7R1fRRLWKipYaQ6oUWw6I3G4GApNPx2eeL8+xLwJ4F+fmcfwGyiNtTIfNbkAhecFaJHc786VYo4hiDUiWbmYXVp54jy3MKqofTDPStZj9mD0GEIShRU/d4D1yHPldBwKe5Qf6FxKfrq4+ezg+PTbjucCJcYHXeZJiNgrS8bPZ1fvWuRdv9M6t3G5bogb0gso6spguVkBbOvMALddGAhEoF4nGDg+PEC7rkTPPugWnmH0ysqG9OvGNEgjMdY7yc8RozW3nDmsr962gG+Urh6J/e0DHpVyxnazpuVPFeRKl76MpdWoJxJHSiymKtSygXOAy/tyM28mHd87hWHB7rZC8PY2aHYw95XThPsgrm6m7OvW0r9cFC5sj3zBI1VwC0SMkzoq9NJrqY6DwPnf7rsH0HLwz39go5Mn5abRk1lDS5/n7vrry0HtD74Bcri0YDn/ruBT54PYFrKn5Wlkfq0CwuPh+gksY3oU7Itbj/1ZvPj+pA0EcB/pjt6VSSimooOllEzwYNm5NUA/8SI0RE5LGpD20CRcSDsQDkEYlvpdo/MPfbh8gGqgcNNq5tttMZmf3uzudDwO72jY90dmW+Rzg5nKXqz2qsUCFzjq61xm+k3OLhA9675/N3pFBK4t5OhmPHobPU99j7gLI7W/cYlmTD/W5ddOyzPrUx83bpWKPYjv9Uwb0/qw7s+DXt8tdGU3d1UQeO4hbO9n5RSdIBkqypsQitGkZzaIZYT33jl9vL/TvtnEM4+nKEgThcDYenLns5xIzKqjdUYj0ZULlssgb0hd6/T6V2skTQRskNV3VtLxSPiyKRk74DKUqZrzBvIoyRD62FuJ9bnWJGD+0oEkZgAAhjhcEvu8zQaVO5VfimNMhlSviMGMzDg82+cNvD8zyCiAvgz6unzyQTIAb9jwzTi2XFD8bu1MQS9WyrkU8mqrKMpf9ABjzRmVf0fNalplWNr6Gwq1ICDh+6CGoBxcNey6Fp22XlLb+RoT9pQWB3xxE/iu54z1dAmyRiqLTZ3WD6M59TqNc+cXQ/o5YKhoCVc7jqK3gutPp2Edn20f554zKQ8R1sOLMpfkXiL/f5ZTuueYVqxXYVzUcQiMBLhfgHa41W61LyzRHgBMS4DK9Ibz8P3wdTRxQSYLHTK7CWbfXHd8TlE1EkJlcSYBEQsXtpRJi/G5VUyWoKt9IvP8Dfdq06p7KX8wAAAAASUVORK5CYII=',
            'state' => 'public',
            'title' => 'GodotCon 2024',
            'organizer' => 'Godot Foundation',
            'description' => 'At GodotCon, we celebrate open source and game development through a series of inspiring talks and workshops. Over two days, learn from experts, share your experiences, and enjoy the company of fellow game developers. Hope to see you there!',
            'start_date' => $CURRENTTIME->addDays(14)->setHour(0),
            'end_date' => $CURRENTTIME->addDays(16)->setHour(24)
        ]);
        $eventSecond = Event::create([
            'id' => '656607c6-33c0-4b1e-8972-d106c525fef7',
            'state' => 'public',
            'title' => 'Second Event',
            'organizer' => 'Lumetra',
            'description' => 'This is the second test event.',
        ]);
        $eventDraft = Event::create([
            'id' => 'fcbdaaf0-8aad-4fd8-8f5f-8d2e25347ca2',
            'state' => 'draft',
            'title' => 'Draft Event',
            'organizer' => 'Lumetra',
            'description' => 'This is a draft event.',
        ]);
        $eventHidden = Event::create([
            'id' => '3e527a47-93bf-47cd-8fd1-ed583e6acfb8',
            'state' => 'hidden',
            'title' => 'Hidden Event',
            'organizer' => 'Lumetra',
            'description' => 'This is a hidden event.',
        ]);
        $this->command->comment('[DevSeeder] Created Events');

        // USERS
        $userAdmin = User::create([
            'id' => 'a635c284-3b16-4ed0-bab2-54af4f423fb6',
            'email' => 'admin@local',
            'is_admin' => true,
            'is_event_creator' => true,
            'password' => Hash::make('admin'),
        ]);
        $userOrganizer = User::create([
            'id' => '6f41391d-c200-4061-a004-f08ce39d6b82',
            'email' => 'organizer@local',
            'is_event_creator' => true,
            'password' => Hash::make('organizer'),
        ]);
        $userUser1 = User::create([
            'id' => 'ec809857-ae5d-4f80-9920-98987092acef',
            'email' => 'user1@local',
            'password' => Hash::make('user1'),
        ]);
        $userUser2 = User::create([
            'id' => 'b3e8932e-af61-4669-8e34-5c539d820b5c',
            'email' => 'user2@local',
            'password' => Hash::make('user2'),
        ]);
        $userUser3 = User::create([
            'id' => '8abe2c5a-628a-4bb4-bc69-feade069cbd1',
            'email' => 'user3@local',
            'password' => Hash::make('user3'),
        ]);
        $userUser4 = User::create([
            'id' => '0b3e9710-2d51-422c-af2b-c30c85936f25',
            'email' => 'user4@local',
            'password' => Hash::make('user4'),
        ]);
        $this->command->comment('[DevSeeder] Created Users');

        // ATTENDEES
        $user1Attendee = Attendee::create([
            'id' => 'd54e63df-8f13-41fc-b3b0-7a81506c111f',
            'handle' => 'max-mustermann',
            'first_name' => 'Max',
            'last_name' => 'Mustermann',
            'confirmed' => 1,
            'description' => 'Hey my name is Max Mustermann and I am a test attendee',
            'job_company' => 'BlueRobot Games',
            'job_position' => 'Studio Head / CEO',
            'active' => 1,
            'role' => 'attendee',
            'user_id' => $userUser1->id,
            'event_id' => $eventGodotCon2024->id,
        ]);
        $user2Attendee = Attendee::create([
            'id' => '6ba22185-cda9-4044-bfa8-2d9f4e024273',
            'handle' => 'laura-heimann',
            'confirmed' => 1,
            'active' => 1,
            'role' => 'attendee',
            'user_id' => $userUser2->id,
            'event_id' => $eventGodotCon2024->id,
        ]);
        $user3Attendee = Attendee::create([
            'id' => '3f0d5a3e-dc11-43a6-a0a6-b5ab842be4d7',
            'handle' => 'not-joining-anymore',
            'first_name' => 'Schmax',
            'last_name' => 'Schmustermann',
            'confirmed' => 1,
            'description' => 'I don\'t know what I am doing.',
            'job_company' => 'BlueRobot Games',
            'job_position' => 'Animator',
            'active' => 1,
            'role' => 'attendee',
            'user_id' => $userUser3->id,
            'event_id' => $eventGodotCon2024->id,
        ]);
        $userOrganizerAttendee = Attendee::create([
            'id' => '1c557c96-8cf1-4c7b-87a1-74ff5257cbab',
            'handle' => 'the-organizer',
            'first_name' => 'TheActual',
            'last_name' => 'Organizer',
            'confirmed' => 1,
            'description' => 'I organized the GodotCon2024 event.',
            'job_company' => 'Godot Foundation',
            'job_position' => 'Event Organizer',
            'active' => 1,
            'role' => 'organizer',
            'user_id' => $userOrganizer->id,
            'event_id' => $eventGodotCon2024->id,
        ]);
        $this->command->comment('[DevSeeder] Created Attendees');

        // EVENT NOTES
        $eventNote = EventNote::create([
            'id' => 'e78e07c0-38d4-4fad-8238-8dc7602dc1ec',
            'event_id' => $eventGodotCon2024->id,
            'title' => 'Non sticky Note',
            'text' => 'This is not a sticky note',
            'sticky' => false,
        ]);
        $eventNoteSticky = EventNote::create([
            'id' => '0f17cd6a-8acf-4433-9c7f-df73432b4292',
            'event_id' => $eventGodotCon2024->id,
            'title' => 'Sticky Note',
            'text' => 'This is a sticky note',
            'sticky' => true,
        ]);
        $this->command->comment('[DevSeeder] Created Event Notes');

        $this->command->info('[DevSeeder] Done.');
    }
}
