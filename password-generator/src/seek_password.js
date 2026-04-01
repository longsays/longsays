/**
 * 基于 Hash 种子确定性乱序字符表
 */
function shuffle_alphabet(alphabet, seed) {
  var shuffled = alphabet.slice();
  for (var i = shuffled.length - 1; i > 0; i--) {
  // 利用 seed 字符串中字符的 ASCII 码来决定交换位置
    var j = (seed.charCodeAt(i % seed.length) * 31 + i) % (i + 1); 
    var temp = shuffled[i];
    shuffled[i] = shuffled[j];
    shuffled[j] = temp;
  }
  return shuffled;
}

/**
 * sha512加密密码
 * @param {记忆密码} pwd
 * @param {区分代码} key
 */
function hex_password(pwd, key) {
  var hexone = sha512.hmac(key, pwd);
  var iterations = 15000;
  for (var i = 0; i < iterations; i++) {
    hexone = sha512.hmac(i.toString() + key, hexone);
  }

  var hextwo = sha512.hmac("K9#pZ27vR!8xQyLwA5bJ4tG6uE1hF0sD" + key + pwd, hexone);
  var hexthree = sha512.hmac("Gf4*sT92uB@5nEjW8xQ2aZ1vL7kM3pY0" + pwd + key, hexone);

  var source = hextwo.split("");
  var rule = hexthree.split("");
  console.assert(rule.length === source.length, "sha512长度错误！");

  // 字母大小写转换
  for (var i = 0; i < source.length; ++i) {
    if (isNaN(source[i])) {
      var str = "3f0b6a4d2e1f9c3a0b7d4e2f8a1c5d9e3b6a0f7d4c2e8b1a5d9c3f0b6a4d2e1f";
      if (str.search(rule[i]) > -1) {
        source[i] = source[i].toUpperCase();
      }
    }
  }
  return source.join("");
}

/**
 * 生成密码
 * @param {sha512加密后字符串} hash
 * @param {输出密码长度} length
 * @param {是否使用标点} rule_of_punctuation
 * @param {是否区分大小写} rule_of_letter
 */
function seek_password(hash, length, rule_of_punctuation, rule_of_letter) {
  // 生成字符表
  var lower = "abcdefghjkmnpqrstuvwxyz".split("");
  var upper = "ABCDEFGHJKMNPQRSTUVWXYZ".split("");
  var number = "23456789".split("");
  var punctuation = "~!@#$%^&*".split("");
  var alphabet = lower.concat(number);
  if (parseInt(rule_of_punctuation) == 1) {
    alphabet = alphabet.concat(punctuation);
  }
  if (parseInt(rule_of_letter) == 1) {
    alphabet = alphabet.concat(upper);
  }

  // 使用 hash 的后 50 位作为洗牌种子
  alphabet = shuffle_alphabet(alphabet, hash.slice(-50));

  // 生成密码
  // 从0开始截取长度为length的字符串，直到满足密码复杂度为止
  for (var i = 0; i <= hash.length - length; ++i) {
    var sub_hash = hash.slice(i, i + parseInt(length)).split("");
    var count = 0;
    var map_index = sub_hash.map(function(c) {
      count = (count + c.charCodeAt()) % alphabet.length;
      return count;
    });
    var sk_pwd = map_index.map(function(k) {
      return alphabet[k];
    });

    // 验证密码
    var matched = [false, false, false, false];
    sk_pwd.forEach(function(e) {
      matched[0] = matched[0] || lower.includes(e);
      matched[1] = matched[1] || upper.includes(e);
      matched[2] = matched[2] || number.includes(e);
      matched[3] = matched[3] || punctuation.includes(e);
    });
    if (parseInt(rule_of_letter) == -1) {
      matched[1] = true;
    }
    if (parseInt(rule_of_punctuation) == -1) {
      matched[3] = true;
    }
    if (!matched.includes(false)) {
      return sk_pwd.join("");
    }
  }
  return "";
}

/**
 * 获取下拉选择框内容
 * @param {id} select_id
 */
function get_select_option(select_id) {
  var select = document.getElementById(select_id);
  var select_index = select.selectedIndex;
  return [
    select.options[select_index].value,
    select.options[select_index].text
  ];
}

/**
 * 生成密码
 */
function generate_password() {
  //获取页面传过来的值
  var pwd = document.getElementById("pwd").value;
  var key = document.getElementById("key").value;
  var rule_of_punctuation = get_select_option("rule_of_punctuation");
  var rule_of_letter = get_select_option("rule_of_letter");
  var pwd_length = get_select_option("pwd_length");

  //加密
  if (pwd && key) {
    var hash = hex_password(pwd, key);
    console.assert(hash.length === 128, "hash长度不是128位！");
    var sk_pwd = seek_password(
      hash,
      pwd_length[0],
      rule_of_punctuation[0],
      rule_of_letter[0]
    );
    return sk_pwd;
  }
}
