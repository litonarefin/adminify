const helpers = {

    nonReactive( data ) {
      return JSON.parse( JSON.stringify( data ) );
    },

    getScoreClass(score) {
      if (score >= 90) return "pass";
      if (score >= 50) return "average";
      return "fail";
    },

    markdownToLink(linkUrl) {
      var regularHTML = linkUrl.replace(
        /\[([^\]]+)\]\(([^\)]+)\)/,
        '<a href="$2" rel="noopener" target="_blank">$1</a>'
      );
      return regularHTML;
    },

    fcpScoreClass(seconds) {
      if (seconds < 1.8) return "adminify-ps-pass";
      if (seconds > 1.8 && seconds < 3) return "adminify-ps-average";
      if (seconds > 3) return "adminify-ps-fail";
    },

    lcpScoreClass(seconds) {
      if (seconds < 2.5) return "adminify-ps-pass";
      if (seconds > 2.5 && seconds < 4) return "adminify-ps-average";
      if (seconds > 4) return "adminify-ps-fail";
    },

    fidScoreClass(miliseconds) {
      if (miliseconds < 100) return "adminify-ps-pass";
      if (miliseconds > 100 && miliseconds < 300) return "adminify-ps-average";
      if (miliseconds > 300) return "adminify-ps-fail";
    },

    clsScoreClass(seconds) {
      if (seconds < 0.1) return "adminify-ps-pass";
      if (seconds > 100 && seconds < 300) return "adminify-ps-average";
      if (seconds > 300) return "adminify-ps-fail";
    },

    barClass(index) {
      if (index === 0) {
        return "fast";
      } else if (index == 1) {
        return "average";
      } else if (index == 2) {
        return "slow";
      }
    },


    toRatio( number ) {
      return (number * 100).toFixed(2);
    },

    MilisecondsToSeconds(miliseconds) {
      var seconds, fractionSeconds;
      seconds = miliseconds / 1000;
      fractionSeconds = seconds.toFixed(2);
      return parseFloat(fractionSeconds);
    },

    ProportionToPercentage(proption) {
      return proption.toFixed(2);
    },
    getScoreStatusInt(score, fullMode = false) {
      if ( typeof score == null ) return 0;
      if ( ! fullMode ) score = score * 100;
      if (score >= 90) return 2;
      if (score >= 50) return 1;
      return 0;
    },
    getScoreStatusClass(score, fullMode = false) {
      let scoreInt = this.getScoreStatusInt(score, fullMode);
      if ( scoreInt == 2 ) return "data-metric--pass";
      if ( scoreInt == 1 ) return "data-metric--average";
      return "data-metric--fail";
    },
    getScoreStatus(score, fullMode = false) {
      let scoreInt = this.getScoreStatusInt(score, fullMode);
      if ( scoreInt == 2 ) return "Excellent";
      if ( scoreInt == 1 ) return "Good";
      return "Poor";
    }
}

export default helpers;
