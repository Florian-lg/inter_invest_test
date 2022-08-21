# Installation

Run ``` git clone git@github.com:Florian-lg/inter_invest_test.git```

Run ```docker-compose up --build``` at the root of the **inter_invest_test** project

Run ```docker exec -ti php8.1-fpm bash```

Inside the container navigate to **inter_invest_test** folder

Run ```composer install```

Run ```bin/console do:da:cr```

Run ```bin/console do:sc:up -f```

Run ```bin/console do:fi:lo``` and say yes

Run ```yarn install```

Run ```yarn build```

Now you can open a browser and paste it in url box ```http://inter-invest-test.local/``` or ```localhost```

# Configuration

There is not a lot of option but you can choose the number of companies you to create 
through the DataFixtures by setting a custom value to the ```NB_COMPANIES_TO_CREATE``` property in the ```.env``` file

# How it works

You can create companies using the admin interface (admin credentials are admin@fakemail.com / admin).

Now you can select a company on the website et choose at which date you want to see the company data.

