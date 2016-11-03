#!/usr/bin/env ruby

require_relative 'appointment'


def generateAppointment(clazz)
    app = Appointment.getInstance(clazz)
    r = Random.new()
    app.day = r.rand(1..10000000) % 30 + 1
    app.month = r.rand(1..10000000) % 12 + 1
    app.year = r.rand(2014..2017)
    app.description = "#{app.class} appointment on #{app.month}/#{app.day}/#{app.year}"
    app
end

def generateArray(size)
    apps = []
    # get a rand for class type
    r = Random.new((Time.now.to_f * 100000).round)
    for i in 0..size
        # 0 for OneTime, 1 for Day, 2 for Month
        c = r.rand(0..2)
        case (c)
        when 0
            apps[i] = generateAppointment(:OneTime)
        when 1
            apps[i] = generateAppointment(:Day)
        when 2
            apps[i] = generateAppointment(:Month)
        end
    end
    apps
end

def hints
    puts ' '
    puts 'Search appointments:'
    puts '0: Print all'
    puts '1: One time'
    puts '2: Day'
    puts '3: Month'
    puts '4: Exit'
    puts 'Enter your choice (1..4):'
end

if __FILE__ == $PROGRAM_NAME
    choice = 0
    size = 50
    apps = generateArray(size)
    while choice != 4
        hints
        choice = gets.to_i
        case choice
        when 0
            for i in 0..size
                puts apps[i].description
            end
        when 1
            puts 'Enter a date(mm/dd/yyyy):'
            d = gets.chomp
            nums = d.split('/', 3)
            for i in 0..size
                if apps[i].class.to_s == 'OneTime' && apps[i].occursOn(nums[1].to_i, nums[0].to_i, nums[2].to_i)
                    puts apps[i].description
                end
            end
        when 2
            puts 'Enter a day(1..30) (we do not work on 31th):'
            d = gets.to_i
            for i in 0..size
                puts apps[i].description if apps[i].class.to_s == 'Day' && apps[i].occursOn(d, 0, 0)
            end
        when 3
            puts 'Enter a month(1..12):'
            d = gets.to_i
            for i in 0..size
                puts apps[i].description if apps[i].class.to_s == 'Month' && apps[i].occursOn(0, d, 0)
            end
        when 4
            puts 'Goodbye.'
        end
        puts
    end
end
