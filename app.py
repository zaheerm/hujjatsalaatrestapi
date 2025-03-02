import copy
import datetime
import json
import logging
from chalice import Chalice
from chalice import BadRequestError
import pytz


app = Chalice(app_name='hujjatsalaatrestapi')
# app.log.setLevel(logging.DEBUG)
salaat_times = json.loads(open("chalicelib/salaat_times_by_city.json").read())


@app.route('/city/{city}/year/{year}/month/{month}/day/{day}')
def salaat_time(city, year, month, day):
    try:
        city = city.lower()
        month = str(int(month))
        day = str(int(day))
        app.log.debug("got request for {} {}/{}/{}".format(city, year, month, day))
        tz = pytz.timezone('Europe/London')
        entry = copy.copy(salaat_times[city][month][day])
        for salaat, salaat_time in entry.items():
            hour, minute, second = salaat_time.split(':')
            the_time = datetime.datetime(
                int(year), int(month), int(day),
                int(hour), int(minute), int(second), 0,
                tzinfo=pytz.utc).astimezone(tz)
            entry[salaat] = the_time.strftime("%H:%M")
        return entry
    except (KeyError, ValueError) as exc:
        raise BadRequestError("invalid request")
    except Exception as exc:
        raise BadRequestError("invalid request")

    return entry


@app.route('/cities')
def get_cities():
    return list(salaat_times.keys())

@app.route('/full_json')
def get_json():
    return salaat_times